<template>
    <h1>Sorry, You're Not Authorized to Make This Request</h1>
    <p>Please check your permissions or contact the administrator.</p>

    <div class="image-container">
        <img src="https://httpgoats.com/561.jpg" alt="Unauthorized">
    </div>
</template>

<style scoped>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        .image-container {
            margin: 2rem 0;
        }
        img {
            max-width: 300px;
            height: auto;
        }
        a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>