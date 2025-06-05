let commentSections = document.getElementById("comment_sections");
let newsItemId = commentSections.getAttribute("data-newsItemId");

function loadXMLDoc() {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let newsJSON = JSON.parse(xmlhttp.responseText);

            commentSections.innerHTML = "";
            for (let i = 0; i < newsJSON.length; i++) {
                let newsItem = newsJSON[i];
                commentSections.innerHTML += `
                        <div class='section border-bottom'>
                            <div class='mt-4 mb-4'>
                                <h5 class='scheherazade-new-bold m-0'>${newsItem["user_name"]}:</h5>
                                <p>${newsItem["date_posted"].slice(0, 10)}</p>
                                <p class='title col d-flex align-items-center'>
                                    ${newsItem["comment_text"]}
                                </p>
                            </div>
                        </div>
    
                    `;
            }
        }
    }
    xmlhttp.open("GET", `async_comments.php?id=${newsItemId}`, true);
    xmlhttp.send();
}


window.setInterval(() => {
    loadXMLDoc();
}, 15000)