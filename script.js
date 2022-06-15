const idErrorEl = document.querySelector(".pokedex-search__error-id");
const nameErrorEl = document.querySelector(".pokedex-search__error-name");

const pokedexEl = document.querySelector(".pokedex");
const pokedexImgEl = document.querySelector(".pokedex__img-container-content img");

if (idErrorEl.style.display === "block") {
    setTimeout (() => idErrorEl.style.display = "none", 3000)
}

if (nameErrorEl.style.display === "block") {
    setTimeout (() => nameErrorEl.style.display = "none", 3000)
}

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
}

