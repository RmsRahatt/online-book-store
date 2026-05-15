document.addEventListener('DOMContentLoaded', function() {
    
    const searchInput = document.getElementById('search-box');
    const filterSelect = document.getElementById('search-filter');
    const resultsContainer = document.getElementById('book-results');

    function fetchBooks() {
        const query = searchInput.value;
        const filter = filterSelect.value;

        fetch(`api.php?q=${encodeURIComponent(query)}&filter=${encodeURIComponent(filter)}`)
            .then(response => response.json()) 
            .then(data => {
                
                resultsContainer.innerHTML = ''; 

                if (data.length === 0) {
                    resultsContainer.innerHTML = '<p>No books found matching your search.</p>';
                    return;
                }

                data.forEach(book => {
                    const bookHTML = `
                        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                            <h3>${book.title}</h3>
                            <p><strong>Author:</strong> ${book.author}</p>
                            <p><strong>Category:</strong> ${book.category_name}</p>
                            <p><strong>Price:</strong> $${book.price}</p>
                            <a href="test.php?id=${book.id}">View Details</a>
                        </div>
                    `;
                    resultsContainer.innerHTML += bookHTML;
                });
            })
            .catch(error => {
                console.error('Error fetching books:', error);
                resultsContainer.innerHTML = '<p style="color:red;">Failed to load books.</p>';
            });
    }

    searchInput.addEventListener('input', fetchBooks);
    
    filterSelect.addEventListener('change', fetchBooks);
});