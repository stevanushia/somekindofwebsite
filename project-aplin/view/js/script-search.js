let num_cards_GLOBAL = 5;

let cards = []; // Array to store the fetched data
let searchedCards = []; // Array to store the searched data

// Make an AJAX request to fetch data from the database
var currentLocation = window.location.href;
var ajaxUrl = currentLocation.replace('view/search.php', 'library/movies-search.php');

console.log(ajaxUrl);

console.log('----------------------------------------------------');




var params = new URLSearchParams(window.location.search);
// Get the value of the 'id' parameter
var q = params.get('q');
var categories = params.get('categories');
console.log("Searched: " + q);

var adminURL = currentLocation.replace('view/search.php?q=' + q, 'admin/');

console.log('adminURL : ' , adminURL);

function containsWord(word, substring) {
    var pattern = new RegExp(substring, "i"); // "i" flag for case-insensitive matching
    return pattern.test(word);
}

$.ajax({
    url: ajaxUrl, // Replace with the actual URL to your server-side PHP script
    method: 'GET', // Use the appropriate HTTP method (GET, POST, etc.)
    dataType: 'json', // The expected data type of the response
    cache: false,

    success: function (data) {
        // The 'data' parameter contains the response from the server
        // Assuming the response is an array of objects, each representing a movie
        // console.log(JSON.stringify(data));
        console.log('check : ' + adminURL + data[1].thumbnail);
        for (var i = 0; i < data.length; i++) {
            var movie = {
                id: data[i].id,
                background: adminURL + data[i].thumbnail,
                display_background: adminURL + data[i].thumbnail,
                title: data[i].title,
                description: data[i].description
            };
            if(containsWord(movie.title, q)){
                console.log(movie.title + " is included in search results");
                searchedCards.push(movie);
            }
            
            // cards.push(movie);
        }
        AddCards();
        // Now you have the data stored in the 'cards' array as objects
        // console.log(cards);
    },

    error: function (xhr, status, error) {
        // Handle the error if the request fails
        console.log('Error:', error);
    }
});

var urlGlobalFilms = currentLocation.replace('view/search.php', 'library/movies-list.php');
$.ajax({
    url: urlGlobalFilms, // Replace with the actual URL to your server-side PHP script
    method: 'GET', // Use the appropriate HTTP method (GET, POST, etc.)
    dataType: 'json', // The expected data type of the response
    cache: false,

    success: function (data) {
        // The 'data' parameter contains the response from the server
        // Assuming the response is an array of objects, each representing a movie
        // console.log(JSON.stringify(data));

        for (var i = 0; i < data.length; i++) {
            var movie = {
                id: data[i].id,
                background: adminURL + data[i].thumbnail,
                display_background: adminURL + data[i].thumbnail,
                title: data[i].title,
                description: data[i].description
            };
            
            cards.push(movie);
        }
        // AddCards();

        // Now you have the data stored in the 'cards' array as objects
        // console.log(cards);
    },

    error: function (xhr, status, error) {
        // Handle the error if the request fails
        console.log('Error:', error);
    }
});

const IsMobile = () => {
    let width =
        window.innerWidth ||
        document.documentElement.clientWidth ||
        document.getElementsByTagName("body")[0].clientWidth;

    if (width <= 736) {
        return true;
    } else {
        return false;
    }
};

const CheckSizeAttributes = () => {
    let width =
        window.innerWidth ||
        document.documentElement.clientWidth ||
        document.getElementsByTagName("body")[0].clientWidth;

    let carousels = document.getElementsByClassName("card-carousel");
    
        let carouselsSearched = document.getElementsByClassName("card-carousel-searched");


    //searched carousels
    if (searchedCards.length > 0) {
        let old_num_cards = num_cards_GLOBAL;
        let new_num_cards;

        if (width > 1501) {
            new_num_cards = 5;
        } else if (width <= 1500 && width > 1100) {
            new_num_cards = 4;
        } else if (width <= 1100 && width > 520) {
            new_num_cards = 3;
        } else if (width <= 520) {
            new_num_cards = 2;
        }

        for (let i = 0; i < carouselsSearched.length; i++) {
            if (carouselsSearched[i].children.length > 2) {
                for (let j = 1; j < carouselsSearched[i].children.length - 1; j++) {
                    carouselsSearched[i].children[j].style.display = "none";
                }
                for (let j = 1; j < new_num_cards + 1; j++) {
                    carouselsSearched[i].children[j].style.display = "flex";
                }
            }
        }

        num_cards_GLOBAL = new_num_cards;
    }


    //global carousels
    let old_num_cards = num_cards_GLOBAL;
    let new_num_cards;

    if (width > 1501) {
        new_num_cards = 5;
    } else if (width <= 1500 && width > 1100) {
        new_num_cards = 4;
    } else if (width <= 1100 && width > 520) {
        new_num_cards = 3;
    } else if (width <= 520) {
        new_num_cards = 2;
    }

    for (let i = 0; i < carousels.length; i++) {
        if (carousels[i].children.length > 2) {
            for (let j = 1; j < carousels[i].children.length - 1; j++) {
                carousels[i].children[j].style.display = "none";
            }
            for (let j = 1; j < new_num_cards + 1; j++) {
                carousels[i].children[j].style.display = "flex";
            }
        }
    }

    num_cards_GLOBAL = new_num_cards;
};

const ResizeHeader = () => {
    let width =
        window.innerWidth ||
        document.documentElement.clientWidth ||
        document.getElementsByTagName("body")[0].clientWidth;

    if (width <= 815) {
        if (document.getElementsByClassName("hamburger").length <= 0) {
            let header = document.getElementsByClassName("header")[0];
            let main_nav = header.getElementsByClassName("main-nav")[0];
            let right_nav = header.getElementsByClassName("right-nav")[0];

            let hamburger = document.createElement("div");
            hamburger.classList.add("hamburger");
            hamburger.innerHTML = `<svg fill="currentColor" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
    </svg>`;
            main_nav.remove();
            right_nav.remove();

            let bottom_header = document.createElement("div");
            bottom_header.classList.add("header-bottom");
            bottom_header.append(main_nav, right_nav);
            bottom_header.style.display = "none";

            hamburger.addEventListener("click", function () {
                if (bottom_header.style.display == "none") {
                    bottom_header.style.display = "flex";
                    header.style.paddingBottom = "9px";
                    header.style.paddingTop = "9px";
                } else {
                    bottom_header.style.display = "none";
                    header.style.paddingBottom = "0px";
                    header.style.paddingTop = "0px";
                }
            });

            header.classList.add("header-change");

            let top_header = document.createElement("div");
            top_header.classList.add("header-top");
            top_header.append(header.children[0], hamburger);

            header.innerHTML = "";
            header.append(top_header, bottom_header);
        }
    } else {
        if (document.getElementsByClassName("hamburger").length > 0) {
            let header = document.getElementsByClassName("header")[0];
            let main_nav = header.getElementsByClassName("main-nav")[0];
            let right_nav = header.getElementsByClassName("right-nav")[0];
            let brand = header.getElementsByClassName("brand")[0];

            header.classList.remove("header-change");
            header.children[0].remove();
            header.children[0].remove();
            header.append(brand, main_nav, right_nav);
        }
    }
};

const AddCards = () => {
    
    let carousel_width = document.getElementsByClassName("card-carousel")[0]
        .clientWidth;
    
        let carousel_searched_width = document.getElementsByClassName("card-carousel-searched")[0]
            .clientWidth;
    

    let btn_width =
        document.getElementsByClassName("carousel-btn")[0].clientWidth +
        document.getElementsByClassName("carousel-btn")[1].clientWidth;

    let num_cards = num_cards_GLOBAL;
    let card_margin = 2;
    let initial_width = 1920;
    let initial_height = 1080;

    let scale =
        (100 * ((carousel_width - btn_width) / num_cards - card_margin * 2)) /
        initial_width;

    let scaleSearched =
        (100 * ((carousel_searched_width - btn_width) / num_cards - card_margin * 2)) /
        initial_width;

    let content_titles = document.getElementsByClassName("content-title");

    for (let i = 0; i < content_titles.length; i++) {
        content_titles[i].style.marginLeft = `${card_margin}px`;
    }

    let carousels = document.getElementsByClassName("card-carousel");
    let carouselsSearched = document.getElementsByClassName("card-carousel-searched");
    



    if(searchedCards.length > 0) { 
        for (let i = 0; i < carouselsSearched.length; i++) {
            let not_chosen = [];

            for (let c = 0; c < searchedCards.length; c++) {
                not_chosen.push(c);
            }

            for (let j = 0; j < searchedCards.length; j++) {
                let chosen_index = 0;

                let chosen_card = searchedCards[not_chosen[chosen_index]];

                not_chosen.splice(chosen_index, 1);

                let card = document.createElement("div");
                card.classList.add("card");
                card.style.backgroundImage = `url(${chosen_card.background})`;

                //If image doesn't load
                card.style.backgroundColor = `#333`;

                card.style.width = initial_width * (scaleSearched / 100) + "px";
                card.style.height = initial_height * (scaleSearched / 100) + "px";
                card.style.margin = `0px ${card_margin}px`;
                card.style.minWidth = initial_width * (scaleSearched / 100) + "px";
                card.style.minHeight = initial_height * (scaleSearched / 100) + "px";

                let overlay = document.createElement("div");
                overlay.classList.add("overlay");

                let title = document.createElement("h4");
                title.innerText = chosen_card.title;
                let description = document.createElement("p");
                description.innerText = "1h 25m";

                let button_container = document.createElement("div");
                button_container.classList.add("button-container");

                let button1 = document.createElement("div");
                let cardsId = searchedCards[j].id;
                button1.innerHTML = `
                    <form method='get' action='movie.php'>
                        <input type='hidden' name='film' value='` + cardsId + `'/>
                        <button type='submit' style="border: none;
                        background-color: transparent;
                        color: white;
                        font-weight: bold;
                        cursor: pointer;
                        ">Play</button>
                    </form>
                    </svg>
                    
                    `;
                button1.classList.add("watch");


                let button3 = document.createElement("div");
                button3.innerHTML = `<svg fill="currentColor" viewBox="0 0 16 16">
        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
        </svg>`;


                let button4 = document.createElement("div");
                button4.innerHTML = `<svg fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
        </svg>`;
                button4.classList.add("star");

                button4.addEventListener("click", function () {
                    if (document.getElementsByClassName("movie-desc").length > 0) {
                        // If the modal exists
                        document.getElementsByClassName("movie-desc")[0].remove();
                    } else {
                        let modal = document.createElement("div");
                        modal.classList.add("movie-desc");

                        let modal_content = document.createElement("div");
                        modal_content.classList.add("modal-content");

                        let bg_image = document.createElement("div");
                        bg_image.classList.add("desc-image");
                        bg_image.style.backgroundImage = `url(${chosen_card.background})`;
                        let image_cover = document.createElement("div");

                        let close_btn = document.createElement("div");
                        close_btn.classList.add("close-btn");
                        close_btn.innerHTML = `<svg fill="currentColor" viewBox="0 0 16 16">
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
        </svg>`;

                        close_btn.addEventListener("click", function () {
                            this.parentElement.parentElement.parentElement.parentElement.remove();
                        });

                        image_cover.append(close_btn);
                        bg_image.append(image_cover);

                        let top_info = document.createElement("div");
                        top_info.classList.add("desc-top");
                        let title = document.createElement("h1");
                        title.innerText = chosen_card.title;

                        let btn_selection = document.createElement("div");
                        btn_selection.classList.add("button-selection");
                        btn_selection.innerHTML = `
                                
                                    <button class="watch" style="border-radius: 5px;border: none;height: 40px;padding-top: 10px;
                                    width: 80px;">
                                    <h3>Play</h3>
                                    <svg fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                        <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z"></path>
                                    </svg>
                                </button>`;

                        top_info.append(title, btn_selection);

                        let mid_info = document.createElement("div");
                        mid_info.classList.add("desc-mid");
                        mid_info.innerHTML = `<p>${chosen_card.description}</p>`;

                        let bottom_info = document.createElement("div");
                        bottom_info.classList.add("desc-bottom");

                        let cast_slider = document.createElement("div");
                        cast_slider.classList.add("cast");

                        bottom_info.append(cast_slider);

                        modal_content.append(
                            bg_image,
                            top_info,
                            mid_info,
                            bottom_info
                        );
                        modal.append(modal_content);

                        document.body.append(modal);

                        document.body.addEventListener("click", function (event) {
                            if (!event.target.classList.contains("modal-content")) {
                                //modal.remove();
                                console.log(1);
                            }
                        });

                        // Set the height for the modal image
                        let total_width = document.getElementsByClassName(
                            "modal-content"
                        )[0].clientWidth;
                        let large_scale = (100 * total_width) / 1920;
                        document.getElementsByClassName(
                            "desc-image"
                        )[0].style.height = `${1080 * (large_scale / 100)}px`;

                        // Set image for cast
                        for (let c = 0; c < cast.length; c++) {
                            let cast_block = document.createElement("div");
                            cast_block.classList.add("cast-card");
                            cast_block.style.backgroundImage = `url("${cast[c].picture}")`;
                            cast_block.style.width = 100 / cast.length - 5 + "%";
                            cast_block.style.height = `calc(${
                                    document.getElementsByClassName("cast")[0]
                                        .clientWidth / cast.length
                                }"px" - 5%)`;
                            cast_slider.append(cast_block);
                        }
                    }
                });

                button_container.append(button1, button4);

                overlay.append(title, description, button_container);
                card.append(overlay);
                if (j < num_cards) {
                    carouselsSearched[i].insertBefore(
                        card,
                        carouselsSearched[i].children[carouselsSearched[i].children.length - 1]
                    );
                } else {
                    card.style.display = "none";
                    carouselsSearched[i].insertBefore(
                        card,
                        carouselsSearched[i].children[carouselsSearched[i].children.length - 1]
                    );
                }
            }
        }
    }





    //global
    for (let i = 0; i < carousels.length; i++) {
        let not_chosen = [];

        for (let c = 0; c < cards.length; c++) {
            not_chosen.push(c);
        }

        for (let j = 0; j < cards.length; j++) {
            let chosen_index = 0;

            let chosen_card = cards[not_chosen[chosen_index]];

            not_chosen.splice(chosen_index, 1);

            let card = document.createElement("div");
            card.classList.add("card");
            card.style.backgroundImage = `url(${chosen_card.background})`;

            //If image doesn't load
            card.style.backgroundColor = `#333`;

            card.style.width = initial_width * (scale / 100) + "px";
            card.style.height = initial_height * (scale / 100) + "px";
            card.style.margin = `0px ${card_margin}px`;
            card.style.minWidth = initial_width * (scale / 100) + "px";
            card.style.minHeight = initial_height * (scale / 100) + "px";

            let overlay = document.createElement("div");
            overlay.classList.add("overlay");

            let title = document.createElement("h4");
            title.innerText = chosen_card.title;
            let description = document.createElement("p");
            description.innerText = "1h 25m";

            let button_container = document.createElement("div");
            button_container.classList.add("button-container");

            let button1 = document.createElement("div");
            let cardsId = cards[j].id;
            button1.innerHTML = `
                <form method='get' action='movie.php'>
                    <input type='hidden' name='film' value='` + cardsId + `'/>
                    <button type='submit' style="border: none;
                    background-color: transparent;
                    color: white;
                    font-weight: bold;
                    cursor: pointer;
                    ">Play</button>
                </form>
                </svg>
                
                `;
            button1.classList.add("watch");


            let button3 = document.createElement("div");
            button3.innerHTML = `<svg fill="currentColor" viewBox="0 0 16 16">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>`;


            let button4 = document.createElement("div");
            button4.innerHTML = `<svg fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>`;
            button4.classList.add("star");

            button4.addEventListener("click", function () {
                if (document.getElementsByClassName("movie-desc").length > 0) {
                    // If the modal exists
                    document.getElementsByClassName("movie-desc")[0].remove();
                } else {
                    let modal = document.createElement("div");
                    modal.classList.add("movie-desc");

                    let modal_content = document.createElement("div");
                    modal_content.classList.add("modal-content");

                    let bg_image = document.createElement("div");
                    bg_image.classList.add("desc-image");
                    bg_image.style.backgroundImage = `url(${chosen_card.background})`;
                    let image_cover = document.createElement("div");

                    let close_btn = document.createElement("div");
                    close_btn.classList.add("close-btn");
                    close_btn.innerHTML = `<svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>`;

                    close_btn.addEventListener("click", function () {
                        this.parentElement.parentElement.parentElement.parentElement.remove();
                    });

                    image_cover.append(close_btn);
                    bg_image.append(image_cover);

                    let top_info = document.createElement("div");
                    top_info.classList.add("desc-top");
                    let title = document.createElement("h1");
                    title.innerText = chosen_card.title;

                    let btn_selection = document.createElement("div");
                    btn_selection.classList.add("button-selection");
                    btn_selection.innerHTML = `
                            
                                <button class="watch" style="border-radius: 5px;border: none;height: 40px;padding-top: 10px;
                                width: 80px;">
                                <h3>Play</h3>
                                <svg fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                    <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z"></path>
                                </svg>
                            </button>`;

                    top_info.append(title, btn_selection);

                    let mid_info = document.createElement("div");
                    mid_info.classList.add("desc-mid");
                    mid_info.innerHTML = `<p>${chosen_card.description}</p>`;

                    let bottom_info = document.createElement("div");
                    bottom_info.classList.add("desc-bottom");

                    let cast_slider = document.createElement("div");
                    cast_slider.classList.add("cast");

                    bottom_info.append(cast_slider);

                    modal_content.append(
                        bg_image,
                        top_info,
                        mid_info,
                        bottom_info
                    );
                    modal.append(modal_content);

                    document.body.append(modal);

                    document.body.addEventListener("click", function (event) {
                        if (!event.target.classList.contains("modal-content")) {
                            //modal.remove();
                            console.log(1);
                        }
                    });

                    // Set the height for the modal image
                    let total_width = document.getElementsByClassName(
                        "modal-content"
                    )[0].clientWidth;
                    let large_scale = (100 * total_width) / 1920;
                    document.getElementsByClassName(
                        "desc-image"
                    )[0].style.height = `${1080 * (large_scale / 100)}px`;

                    // Set image for cast
                    for (let c = 0; c < cast.length; c++) {
                        let cast_block = document.createElement("div");
                        cast_block.classList.add("cast-card");
                        cast_block.style.backgroundImage = `url("${cast[c].picture}")`;
                        cast_block.style.width = 100 / cast.length - 5 + "%";
                        cast_block.style.height = `calc(${
                                document.getElementsByClassName("cast")[0]
                                    .clientWidth / cast.length
                            }"px" - 5%)`;
                        cast_slider.append(cast_block);
                    }
                }
            });

            button_container.append(button1, button4);

            overlay.append(title, description, button_container);
            card.append(overlay);
            if (j < num_cards) {
                carousels[i].insertBefore(
                    card,
                    carousels[i].children[carousels[i].children.length - 1]
                );
            } else {
                card.style.display = "none";
                carousels[i].insertBefore(
                    card,
                    carousels[i].children[carousels[i].children.length - 1]
                );
            }
        }
    }
};

const CheckCards = () => {
    let carousels = document.getElementsByClassName("card-carousel");
    let carouselsSearched = document.getElementsByClassName("card-carousel-searched");
    //searched carousels
    if(searchedCards.length > 0) { 
        for (let i = 0; i < carouselsSearched.length; i++) {
            let carousel_width = carouselsSearched[i].clientWidth;
    
            let btn_width =
                carouselsSearched[i].getElementsByClassName("carousel-btn")[0].clientWidth +
                carouselsSearched[i].getElementsByClassName("carousel-btn")[1].clientWidth;
    
            let num_cards = num_cards_GLOBAL;
            let card_margin = 2;
            let initial_width = 1920;
            let initial_height = 1080;
    
            let scale =
                (100 *
                    ((carousel_width - btn_width) / num_cards - card_margin * 2)) /
                initial_width;
    
            let cards = carouselsSearched[i].getElementsByClassName("card");
    
            for (let i = 0; i < cards.length; i++) {
                cards[i].style.width = initial_width * (scale / 100) + "px";
                cards[i].style.height = initial_height * (scale / 100) + "px";
                cards[i].style.margin = `0px ${card_margin}px`;
                cards[i].style.minWidth = initial_width * (scale / 100) + "px";
                cards[i].style.minHeight = initial_height * (scale / 100) + "px";
            }
    
            if (IsMobile()) {
                carouselsSearched[i].style.height =
                    1.6 * (initial_height * (scale / 100)) + "px";
            } else {
                carouselsSearched[i].style.height = "auto";
            }
        }
    }

    //global carousels
    for (let i = 0; i < carousels.length; i++) {
        let carousel_width = carousels[i].clientWidth;

        let btn_width =
            carousels[i].getElementsByClassName("carousel-btn")[0].clientWidth +
            carousels[i].getElementsByClassName("carousel-btn")[1].clientWidth;

        let num_cards = num_cards_GLOBAL;
        let card_margin = 2;
        let initial_width = 1920;
        let initial_height = 1080;

        let scale =
            (100 *
                ((carousel_width - btn_width) / num_cards - card_margin * 2)) /
            initial_width;

        let cards = carousels[i].getElementsByClassName("card");

        for (let i = 0; i < cards.length; i++) {
            cards[i].style.width = initial_width * (scale / 100) + "px";
            cards[i].style.height = initial_height * (scale / 100) + "px";
            cards[i].style.margin = `0px ${card_margin}px`;
            cards[i].style.minWidth = initial_width * (scale / 100) + "px";
            cards[i].style.minHeight = initial_height * (scale / 100) + "px";
        }

        if (IsMobile()) {
            carousels[i].style.height =
                1.6 * (initial_height * (scale / 100)) + "px";
        } else {
            carousels[i].style.height = "auto";
        }
    }
};

const AddCarouselButtons = () => {
    let carousels = document.getElementsByClassName("card-carousel");
    let carouselsSearched = document.getElementsByClassName("card-carousel-searched");
    //searched carousels
    if(searchedCards.length > 0) { 
        for (let i = 0; i < carouselsSearched.length; i++) {
            let btn1 = document.createElement("div");
            btn1.classList.add("carousel-btn");
            btn1.innerHTML = `<svg fill="currentColor" viewBox="0 0 16 16" onclick="Previous(this);">
                                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                </svg>`;
    
            let btn2 = document.createElement("div");
            btn2.classList.add("carousel-btn");
    
            btn2.innerHTML = `<svg fill="currentColor" viewBox="0 0 16 16" onclick="Next(this);">
                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                </svg>`;
    
            carouselsSearched[i].append(btn1, btn2);
        }
    }

    //global carousels
    for (let i = 0; i < carousels.length; i++) {
        let btn1 = document.createElement("div");
        btn1.classList.add("carousel-btn");
        btn1.innerHTML = `<svg fill="currentColor" viewBox="0 0 16 16" onclick="Previous(this);">
                                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                            </svg>`;

        let btn2 = document.createElement("div");
        btn2.classList.add("carousel-btn");

        btn2.innerHTML = `<svg fill="currentColor" viewBox="0 0 16 16" onclick="Next(this);">
                                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                            </svg>`;

        carousels[i].append(btn1, btn2);
    }
};

const ScrollFunction = () => {
    let header = document.getElementsByClassName("header")[0];
    if (document.documentElement.scrollTop > 1) {
        header.classList.add("header-active");
    } else {
        header.classList.remove("header-active");
    }
};

const MakeJumbotron = () => {
    let height =
        window.innerHeight ||
        document.documentElement.clientHeight ||
        document.getElementsByTagName("body")[0].clientHeight;

    document.getElementsByClassName("top")[0].style.height = `${height}px`;
};

let slide_index = 0;

const AutoSlideShow = () => {
    let slide_area = document.getElementsByClassName("top")[0];
    let container = slide_area.children[0];

    container.classList.add("fadeIn");

    let bg_display = [];
    for (let i = 0; i < cards.length; i++) {
        if (cards[i].display_background) {
            bg_display.push(i);
        }
    }

    slide_index++;
    if (slide_index > bg_display.length - 1) {
        slide_index = 0;
    }

    slide_area.style.backgroundImage = `url("${
            cards[bg_display[slide_index]].display_background
        }")`;
    slide_area.getElementsByTagName("h1")[0].innerHTML =
        cards[bg_display[slide_index]].title;
    slide_area.getElementsByTagName("p")[0].innerHTML =
        cards[bg_display[slide_index]].description;

    container.classList.add("fadeOut");
    setTimeout(AutoSlideShow, 2000);
};

const SmoothScroll = (id) => {
    let element = document.getElementById(id);
    element.scrollIntoView({
        behavior: "smooth",
        block: "center"
    });
};

const Next = (elem) => {
    let carousel = elem.parentElement.parentElement;
    let first_elem = carousel.children[1];
    let next_elem;

    for (let i = 0; i < carousel.children.length; i++) {
        if (carousel.children[i].style.display == "none") {
            next_elem = carousel.children[i];
            break;
        }
    }

    first_elem.style.display = "none";
    first_elem.remove();
    carousel.insertBefore(
        first_elem,
        carousel.children[carousel.children.length - 1]
    );

    next_elem.style.display = "flex";
};

const Previous = (elem) => {
    let carousel = elem.parentElement.parentElement;
    let last_display_item;
    let prev_elem = carousel.children[carousel.children.length - 2];

    for (let i = 0; i < carousel.children.length; i++) {
        if (
            carousel.children[i].style.display != "none" &&
            !carousel.children[i].classList.contains("carousel-btn")
        ) {
            last_display_item = carousel.children[i];
        }
    }

    last_display_item.style.display = "none";

    carousel.insertBefore(prev_elem, carousel.children[1]);

    prev_elem.style.display = "flex";
};
