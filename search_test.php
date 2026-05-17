<?php require_once 'view/partials/header.php'; ?>

<h1>Search Books</h1>

<div class="search-container">
    <select id="search-filter" class="search-filter">
        <option value="title">By Title</option>
        <option value="author">By Author</option>
        <option value="category">By Genre</option>
    </select>
    
    <input type="text" id="search-box" class="search-input" placeholder="Start typing to search..." autocomplete="off">
</div>

<hr>

<div id="book-results" class="results-grid">
    <p>Type above to start searching...</p>
</div>

<script src="public/js/search.js"></script>

<?php require_once 'view/partials/footer.php'; ?>