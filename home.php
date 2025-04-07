
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LIFE WITHIN US Co.</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>

    <style>
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body and Basic Styling */
body {
    font-family: 'Times New Roman', Times, serif;
    line-height: 1.6;
    background-color: #f4f4f4;
}
.button-container {
    background-color: #333;
    display: flex;
    justify-content: flex-end; /* Aligns buttons to the left */
    gap: 10px; /* Adds space between buttons */
  }

  .button-container a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50; /* Green background */
    color: white;
    text-decoration: none; /* Removes underline */
    border-radius: 5px;
    text-align: center;
    font-size: 16px;
  }

  .button-container a:hover {
    background-color: #45a049; /* Darker green on hover */
  }
/* Header */
header {
    background-color: #091479;
    color: white;
    padding: 20px 0;
}

header h1 {
    text-align: center;
    font-size: 80px;
}
.image-containers {
    text-align: center;
    display: flex;
    
}
.image-containers img {
    max-width: 100%;
    height: auto;
    margin-right: 10px; /* Adjust space between images */
    margin-left: 10%;
}
nav ul {
    list-style: none;
    text-align: center;
    padding: 10px 0;
}

nav ul li {
    display: inline;
    margin: 0 15px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
}

/* Hero Section */
#hero {
    background-color: #2196F3;
    color: white;
    padding: 60px 0;
    text-align: center;
}

.cta-button {
    background-color: #fff;
    color: #2196F3;
    padding: 10px 20px;
    text-decoration: none;
    font-size: 18px;
    border-radius: 5px;
    margin-top: 20px;
}

.cta-button:hover {
    background-color: #4CAF50;
    color: white;
}

/* Section Styling */
section {
    padding: 40px 0;
}

.container {
    width: 80%;
    margin: 0 auto;
}

.service {
    background-color: #11a0e2;
    padding: 20px;
    margin: 10px 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
#services{
    background-color: #0bc5bc;
}

h2 {
    text-align: center;
    margin-bottom: 50px;
    size: 40px;
}
#contact{
    background-color: #05aa20;
    text-align: center;
}

/* Footer */
footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px 0;
}
.image-container {
    text-align: center;
    display: flex;
    justify-content: space-between;
}
.image-container img {
    max-width: 100%;
    height: auto;
    margin-right: 10px; /* Adjust space between images */
}
    </style>
    <!-- Header -->
    <header>
        <div class="container">
            <h1>LIFE WITHIN US Co.</h1>
            <div class="button-container">
                <a href="signin.php" class="button">Sign In</a>
                <a href="login.php" class="button">Login</a>
              </div><br>
            <div class="image-containers">
                <img src="pic\geto.jpg" alt="children" width="400">
                <img src="pic\child.webp" alt="house" width="400">
            </div><br>
            <nav>
                <ul>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="hero">
        <div class="container">
            <h2>Clean, Safe, and Pure Water Delivered to You</h2>
            <img src="pic\water2.jpg" height="500" width="700">
            <p>Your trusted water provider for home and business needs.</p><br>
            <a href="#services" class="cta-button">Explore Our Services</a>
        </div>
    </section>

    <!-- About Us -->
    <section id="about">
        <div class="container">
            <h2>About Us</h2>
            <div class="image-container">
                <img src="pic\nai.jpg" alt="city" width="300">
                <img src="pic\house.webp" alt="house" width="300">
                <img src="pic\water4.jpg" alt="water can" width="300">
            </div>
            <p>At Pure Water Co., we are committed to providing the highest quality water for your home and business. We offer a range of water delivery and filtration services to ensure that you always have access to clean, safe water.</p>
        </div>
    </section>

    <!-- Services -->
    <section id="services">
        <div class="container">
            <h2>Our Services</h2>
            <div class="service">
                <h3>Home Water Delivery</h3>
                <p>Regular delivery of fresh, purified water to your doorstep.</p>
                <img src="pic\water1.jpg" height="300" width="500">
            </div>
            <div class="service">
                <h3>Business Solutions</h3>
                <p>Reliable water supply for offices, factories, and other businesses.</p>
                <img src="pic\was.webp" height="300" width="500">
            </div>
            <div class="service">
                <h3>Water Filtration Systems</h3>
                <p>High-quality filtration systems to keep your water pure and safe.</p>
                <img src="pic\filter.webp" height="300" width="500">
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <p>If you have any questions or need a quote, feel free to reach out!</p>
            <p>Email: <a href="mailto:info@lifewithin.com">info@purewaterco.com</a></p>
            <p>Phone: +254 708321946</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 LIFE WITHIN US. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
