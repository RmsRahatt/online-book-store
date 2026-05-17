<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Book Store</title>
    <style>
        /* Your original styles */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9; }
        .navbar { background-color: #333; color: white; padding: 15px; display: flex; gap: 20px; }
        .navbar a { color: white; text-decoration: none; font-weight: bold; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 1000px; margin: 20px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }

        /* --- NEW CART STYLES BELOW --- */
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 16px;
            text-align: left;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05); 
        }

        .cart-table thead tr {
            background-color: #333;
            color: #ffffff;
            font-weight: bold;
        }

        .cart-table th, 
        .cart-table td {
            padding: 15px 20px;
            border-bottom: 1px solid #dddddd;
        }

        .cart-table tbody tr:hover {
            background-color: #f5f5f5; 
        }

        .cart-qty {
            width: 60px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .remove-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: #cc0000;
        }

        #checkout-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }
        /* --- SEARCH PAGE STYLES --- */
        .search-container {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .search-filter {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: white;
            cursor: pointer;
        }

        .search-input {
            flex-grow: 1; /* Makes the search bar take up the rest of the space */
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        /* Results Grid & Cards */
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); /* Creates a responsive grid */
            gap: 25px;
        }

        .book-card {
            background: white;
            border: 1px solid #eaeaea;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s; /* Smooth animation */
        }

        .book-card:hover {
            transform: translateY(-5px); /* Lifts the card up slightly */
            box-shadow: 0 8px 15px rgba(0,0,0,0.15); /* Makes the shadow deeper */
        }

        .book-card h3 {
            margin-top: 0;
            color: #222;
            font-size: 1.3em;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        .book-card p {
            color: #555;
            margin: 8px 0;
            line-height: 1.4;
        }

        .book-card .view-btn {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .book-card .view-btn:hover {
            text-decoration: underline;
            color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="index.php">Home / Search</a>
        <a href="index.php?page=cart">My Cart</a>
    </div>

    <div class="container">