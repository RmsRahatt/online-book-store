function loadBooks(categoryId){

    let xhttp = new XMLHttpRequest();

    xhttp.open(
        "GET",
        "../controller/getBooksAjax.php?id="
        + categoryId,
        true
    );

    xhttp.onreadystatechange = function(){

        if(
            this.readyState == 4
            &&
            this.status == 200
        ){

            let response = JSON.parse(
                this.responseText
            );

            if(response.status == "success"){

                let books = response.books;

                let html = "";

                if(books.length == 0){

                    html =
                    "<p>No Books Found</p>";
                }
                else{

                    books.forEach(function(book){

                        html +=
                        "<div class='book-card'>";

                        html +=
                        "<h3>" + book.title + "</h3>";

                        html +=
                        "<p>Author: " + book.author + "</p>";

                        html +=
                        "<p>Price: " + book.price + "</p>";

                        html +=
                        "<p>" + book.description + "</p>";

                        html += "</div>";
                    });
                }

                document.getElementById(
                    "bookResults"
                ).innerHTML = html;
            }
        }
    }

    xhttp.send();
}