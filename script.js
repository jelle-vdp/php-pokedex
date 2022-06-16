const idErrorEl = document.querySelector(".pokedex-search__error-id");
const nameErrorEl = document.querySelector(".pokedex-search__error-name");

const pokedexEl = document.querySelector(".pokedex");
const pokedexImgEl = document.querySelector(".pokedex__img-container-content img");

const pokedexMovesListItems = document.querySelectorAll(".pokedex__moves li");

const pokemonName = document.querySelector(".pokedex__img-container-content h3").innerText.toLowerCase();

const pokemonAttackTotalDamageEl = document.querySelector(".pokedex__attack p");
const pokemonAttacksList = document.querySelector(".pokedex__attack ul");

const pokemonAttacksMsgArr = [];
let totalAmountOfDamage = 0;

if (idErrorEl.style.display === "block") {
    setTimeout (() => idErrorEl.style.display = "none", 3000)
};

if (nameErrorEl.style.display === "block") {
    setTimeout (() => nameErrorEl.style.display = "none", 3000)
};

if (pokedexEl.style.display === "flex") {
    let count = 0;
    spriteInterval = setInterval(() => {
        count++;
        let index = `sprite-${count}`;
        pokedexImgEl.src = pokedexImgEl.dataset[index];
        if (count === 4){
            count = 0;
        };

    }, 1000);
};

pokedexMovesListItems.forEach((li, i) => {
    li.addEventListener("mouseenter", () => {
        pokedexMovesListItems.forEach(listIt => {
            listIt.classList.remove("selected");
        });
        li.classList.add("selected");
    });

    li.addEventListener("click", () => {
        fetch(`https://pokeapi.co/api/v2/pokemon/${pokemonName}`)
        .then(res => res.json())
        .then(data => {
            
            fetch(data.moves[i].move.url)
                .then(res => res.json())
                .then(dataMove => {
                    let randomNum = Math.random();
                    if (randomNum < (dataMove.accuracy / 100)){
                        pokemonAttacksMsgArr.push(`${pokemonName.charAt(0).toUpperCase() + pokemonName.slice(1).replaceAll("-", " ")} performed <b>${dataMove.name.charAt(0).toUpperCase() + dataMove.name.slice(1).replaceAll("-", " ")}</b> succesfully, and inflicted <b>${dataMove.power}</b> damage.`);
                        totalAmountOfDamage += dataMove.power;
                    } else {
                        pokemonAttacksMsgArr.push(`${pokemonName.charAt(0).toUpperCase() + pokemonName.slice(1).replaceAll("-", " ")} performed <b>${dataMove.name.charAt(0).toUpperCase() + dataMove.name.slice(1).replaceAll("-", " ")}</b> unsuccesfully, no damage inflicted.`);
                    };
                    pokemonAttacksList.style.display = "block";
                    pokemonAttacksList.innerHTML = "";
                    pokemonAttackTotalDamageEl.innerHTML = `Total amount of damage afflicted: <b>${totalAmountOfDamage}</b>`;
                    pokemonAttacksMsgArr.forEach(attack => {
                        const attackLi = document.createElement("li");
                        attackLi.innerHTML = attack;
                        pokemonAttacksList.appendChild(attackLi);
                    });
            });
        });
    });
});