<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
    <style>
        /* Your custom CSS for styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #333;
        }

        .input-container {
            display: flex;
            align-items: center;
        }

        .input-icon {
            margin-right: 10px;
            font-size: 20px;
            color: #007bff;
            /* Icon color */
        }

        textarea,
        input[type="number"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Feedback Form</h1>
        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="feedback_text">Feedback Text</label><br>
                <div class="input-container">
                    <textarea name="feedback_text" id="feedback_text" rows="4" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="rating">Rating</label>
                <div class="star-rating" id="star-rating">
                    <i style="color:gold" class="fas fa-star" data-rating="1"></i>
                    <i style="color:gold" class="fas fa-star" data-rating="2"></i>
                    <i style="color:gold" class="fas fa-star" data-rating="3"></i>
                    <i style="color:gold" class="fas fa-star" data-rating="4"></i>
                    <i style="color:gold" class="fas fa-star" data-rating="5"></i>
                    <input type="hidden" name="rating" id="rating" value="0">
                </div>
            </div>
            <div class="form-group">
                <button type="submit">Submit Feedback</button>
            </div>
        </form>
    </div>
    <script src="script.js"></script> <!-- Include your JavaScript file -->

    <script>
        // JavaScript for star rating
        const starRating = document.getElementById('star-rating');
        const ratingInput = document.getElementById('rating');

        starRating.addEventListener('click', (event) => {
            if (event.target.tagName === 'I') {
                const rating = parseInt(event.target.getAttribute('data-rating'));
                ratingInput.value = rating;
                updateStarRating(rating);
            }
        });

        function updateStarRating(rating) {
            const stars = starRating.querySelectorAll('i');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('fas');
                    star.classList.remove('far');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                }
            });
        }
    </script>
</body>

</html>