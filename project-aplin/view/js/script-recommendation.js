

let recomms = [];

// Make an AJAX request to fetch data from the database
var currentLocation = window.location.href;
console.log(currentLocation);
var ajaxUrl = currentLocation.replace('view/profile.php', 'library/recommendation-list.php');
if (ajaxUrl == currentLocation){
    ajaxUrl = currentLocation.replace('view/index.php', 'library/recommendation-list.php');
}
console.log("ajax url : " + ajaxUrl);

var adminURL = currentLocation.replace('view/profile.php', 'admin/');
if (adminURL == currentLocation) {
    adminURL = currentLocation.replace('view/index.php', 'admin/');
}
console.log('adminURL : ' , adminURL);

$.ajax({
    url: ajaxUrl, // Replace with the actual URL to your server-side PHP script
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
                description: data[i].description,
                score: data[i].score
            };
            
            recomms.push(movie);
        }


        AddRecommend();

        // Now you have the data stored in the 'cards' array as objects
        // console.log(cards);
    },

    error: function (xhr, status, error) {
        // Handle the error if the request fails
        console.log('Error:', error);
    }
});

const AddRecommend = () => {    
    let mid = document.getElementsByClassName("card-carousel-recommend")[0];

    let ctr = 0;

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

    let contentArea = document.createElement("div");
    contentArea.className = 'content-area';
    contentArea.id = ctr;

    let contentTitle = document.createElement("h2");
    contentTitle.className = 'content-title';
    contentTitle.innerHTML = 'FOR YOU';

    let cardCarousel = document.createElement("div");
    cardCarousel.className = 'card-carousel';

    cardCarousel.append(btn1);
    let ctrf = 0;
    recomms.forEach(f => {

        let styleDisplay = "display: flex;";
        if (ctrf < 0 || ctrf > 4) styleDisplay = "display: none";
        cardCarousel.innerHTML += `
        <div id="${ctrf}" class="card" style="
            background-image: url(${f.background}); 
            background-color: rgb(51, 51, 51); 
            width: 350px; 
            height: 191.138px; 
            margin: 0px 2px; 
            min-width: 339.8px; 
            min-height: 191.138px;
            ${styleDisplay}">
        <div class="overlay">
        <h4>${f.title}</h4>
        <p>1h 25m</p>
            <div class="button-container">
                <div class="watch">
                    <form method="get" action="movie.php">
                        <input type="hidden" name="film" value="${f.id}">
                        <button type="submit" style="border: none;
                        background-color: transparent;
                        color: white;
                        font-weight: bold;
                        cursor: pointer;
                        ">Play</button>
                    </form>
                </div>
                <div class="star" onclick="popupDescription(this)" idfilm="${f.id}" indexfilm="${ctrf}">
                <svg fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
            </div>
            </div>
            </div>
            </div>`;
        ctrf++;
    });
    contentArea.appendChild(contentTitle);
    cardCarousel.append(btn2);

    contentArea.appendChild(cardCarousel);
    mid.appendChild(contentArea);
    ctr++;
    
}

function popupDescription(prop)
{

    indexFilm = prop.getAttribute("indexfilm");
    idFilm = prop.getAttribute("idfilm");
    let film = recomms[indexFilm];
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
        bg_image.style.backgroundImage = `url(${film.background})`;
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
        title.innerText = film.title;
        title.innerHTML += `<p style='font-size: 20px;'>Critics Score : ${film.score}</p><div class="star-rating" style="--rating: ${film.score}"</div>`;


        let btn_selection = document.createElement("div");
        btn_selection.classList.add("button-selection");
        btn_selection.innerHTML = `
            <form method="get" action="movie.php">
                <input type="hidden" name="film" value="${idFilm}">
                    <button class="watch" style="border-radius: 5px;border: none;height: 40px;padding-top: 10px;
                    width: 80px;">
                    <h3>Play</h3>
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                        <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z"></path>
                    </svg>
                </button>
            </form>`;

        top_info.append(title, btn_selection);
        
        let mid_info = document.createElement("div");
        mid_info.classList.add("desc-mid");
        mid_info.innerHTML = `<p>${film.description}</p>`;

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
}
