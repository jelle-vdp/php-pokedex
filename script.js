const submitBtn = document.querySelector(".btn-findpokemon");
const inputGetPokemon = document.querySelector(".input-findpokemon");

const idErrorEl = document.querySelector(".pokedex-search__error-id");
const nameErrorEl = document.querySelector(".pokedex-search__error-name");


submitBtn.addEventListener("click", (e) => {

    fetch(`https://pokeapi.co/api/v2/pokemon/${searchValue}/`)
        .catch((err) => {
            if (isNaN(+inputGetPokemon.value)){
                e.preventDefault();
                nameErrorEl.style.display = "block";
                setTimeout(() => nameErrorEl.style.display = "none", 5000);
            } else {
                e.preventDefault();
                idErrorEl.style.display = "block";
                setTimeout(() => idErrorEl.style.display = "none", 5000);
            };
        })

    });