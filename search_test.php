<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AJAX Live Search</title>
</head>
<body>
    <h1>Search Books</h1>
    
    <select id="search-filter">
        <option value="title">By Title</option>
        <option value="author">By Author</option>
        <option value="category">By Genre</option>
    </select>
    
    <input type="text" id="search-box" placeholder="Start typing to search..." autocomplete="off">

    <hr>

    <div id="book-results">
        <p>Type above to start searching...</p>
    </div>

    <script src="public/js/search.js"></script>
</body>
</html>