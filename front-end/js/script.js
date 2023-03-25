
// Function responsible for bringing the beckend list
async function leaderboard() {
    try {
        await fetch("http://localhost:3045/listarLeaderboard").then(res => res.json()).then(result => {
            filtering_winners_names(result);
        });
    } catch (error) {
        console.log(error);
    }
};


// Making a filter of the names of the winners
function filtering_winners_names(object) {
    let winner_names = [];
    for (let i = 0; i < object.length; i++) {
        if (!winner_names.includes(object[i].winner_name)) {
            winner_names.push(object[i].winner_name)
        }
    }

    for (let i = 0; i < winner_names.length; i++) {
        filtering_number_of_winning(winner_names[i], object);
    }
}

// Filtering the data of all the games of each player, manipulating them and inserting them in the HTML dynamically
function filtering_number_of_winning(player, object) {
    let total = object.filter(w => w.winner_name == player)

    const cardElement = document.createElement("div");
    cardElement.classList.add('card');

    const cardHeaderElement = document.createElement("div");
    cardHeaderElement.classList.add('card-header');

    const cardBodyElement = document.createElement("div");
    cardBodyElement.classList.add('card-body');

    for (let i = 0; i < total.length; i++) {
        const paragraph = document.createElement("p");
        paragraph.classList.add("card-text");
        const content = document.createTextNode(`Defeated ${total[i].loser_name} in ${total[i].moves} moves`);
        paragraph.appendChild(content);
        cardBodyElement.appendChild(paragraph);
    }

    const newContent = document.createTextNode(`${player} : ${total.length} wins`);
    cardHeaderElement.appendChild(newContent);
    cardElement.appendChild(cardHeaderElement);
    cardElement.appendChild(cardBodyElement);

    // add the newly created element and its content into the DOM
    const currentDiv = document.getElementById("leaderboard");
    currentDiv.appendChild(cardElement);
}


leaderboard();







