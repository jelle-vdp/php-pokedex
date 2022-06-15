<?php 
$displayPokedex;
$displayEvolution;
$displayErrorName;
$displayErrorId;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['btn-findpokemon'])) {

        $searchInput = str_replace(' ', '-', strtolower($_POST["input-findpokemon"]));

        $pokeData = @file_get_contents("https://pokeapi.co/api/v2/pokemon/" . $searchInput);

        if (is_numeric($searchInput) && !$pokeData) {
            $displayErrorId = "style = 'display:block'";
        } elseif ((!is_numeric($searchInput) && !$pokeData) || empty($searchInput)) {
            $displayErrorName = "style = 'display:block'";
        } elseif (!empty($searchInput)) {
            $displayPokedex = "style = 'display:flex'";
            $pokeDataParsed = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/" . $searchInput));

            $pokeSpecies = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon-species/" . $searchInput));

            if($pokeSpecies->evolves_from_species){ 
                $previousEvolution = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/" .$pokeSpecies->evolves_from_species->name));   
                $displayEvolution = "style = 'display:flex'";
            } else {
                $displayEvolution = "style = 'display:none'";
            }
        };
    };
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="style.css" />
  <script src="script.js" defer></script>
</head>

<body>
    <main>
        <form class="pokedex-search" action="index.php" method="POST">
            <p class="pokedex-search__description">Search for a pokémon name or a pokémon ID</p>
            <div class="pokedex-search__bar"> 
                <input class="input-findpokemon" name="input-findpokemon" type="text">
                <button type="submit" class="btn-findpokemon" name="btn-findpokemon">Find your pokémon</button>
            </div>
            <p class="pokedex-search__error pokedex-search__error-id"<?php if(!empty($displayErrorId)){echo $displayErrorId;}?>>
                You gave in a wrong ID, make sure it's between 1 and 898 or between 10001 and 10228.
            </p>
            <p class="pokedex-search__error pokedex-search__error-name"<?php if(!empty($displayErrorName)){echo $displayErrorName;}?>>
                The name you entered isn't a pokémon, maybe you've made a spelling error?
            </p>
        </form>
        <section class="pokedex"<?php if(!empty($displayPokedex)){echo $displayPokedex;}?>>
            <div class="pokedex__left-page">

                <div class="pokedex__left-page-top">
                    <span class="pokedex__big-btn-blue"></span>
                    <span class="pokedex__btn-red"></span>
                    <span class="pokedex__btn-yellow"></span>
                    <span class="pokedex__btn-green"></span>
                </div>
                <div class="pokedex__left-page-middle">
                    <div class="pokedex__img-container">

                        <div class="pokedex__img-container-top">
                            <div class="pokedex__dot-container">
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                            
                        <div class="pokedex__img-container-content">
                            <img src="<?php echo $pokeDataParsed->sprites->front_default; ?>" data-sprite-1="<?php echo $pokeDataParsed->sprites->front_default; ?>" data-sprite-2="<?php echo $pokeDataParsed->sprites->back_default; ?>" data-sprite-3="<?php echo $pokeDataParsed->sprites->front_shiny; ?>" data-sprite-4="<?php echo $pokeDataParsed->sprites->back_shiny; ?>">
                            <h3><?php echo str_replace('-', ' ', ucfirst($pokeDataParsed->name)); ?></h3>
                        </div>

                        <div class="pokedex__img-container-bottom">
                            <span class="pokedex__red-btn"></span>
                            <div class="pokedex__bars">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="pokedex__left-page-bottom">
                    <div class="pokedex__left-page-bottom-left">
                        <span class="pokedex__black-btn"></span>
                    </div>
                    <div class="pokedex__left-page-bottom-middle">
                        <span class="pokedex__green-btn"></span>
                        <span class="pokedex__orange-btn"></span>
                        <p class="pokedex__index">
                            <?php echo $pokeDataParsed->id; ?>
                        </p>
                    </div>
                    <div class="pokedex__controller">
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
            
            <div class="pokedex__right-page">
                <div class="pokedex__moves">
                    <h3>
                        <?php 
                            if (count($pokeDataParsed->moves) === 1){
                                echo "The move of your pokémon:";
                            } else {
                                echo "Some moves of your pokémon:";
                            } 
                        ?>
                    </h3>
                    <ul>
                        <?php
                            if (count($pokeDataParsed->moves) < 5){
                                $maxLoop = count($pokeDataParsed->moves);
                            } else {
                                $maxLoop = 5;
                            };

                            $openLi;
                            for ($i = 0; $i <= $maxLoop; $i++) {
                                if ($i === 0) {$openLi = "<li class='selected'>";} else {$openLi = "<li>";};
                                echo $openLi . str_replace('-', ' ',ucfirst($pokeDataParsed->moves[$i]->move->name)) . "</li>";
                            };
                        ?> 
                    </ul>
                </div>
                <div class="pokedex__previous-evolution"<?php if(!empty($displayEvolution)){echo $displayEvolution;}?>>
                    <h3>Previous evolution:</h3>
                    <h4><?php echo str_replace('-', ' ', ucfirst($previousEvolution->name)); ?></h4>
                    <img src="<?php echo $previousEvolution->sprites->front_default; ?>"/>
                </div>
            </div>
        </section>
    </main>
</body>
</html>