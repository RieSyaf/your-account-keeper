@extends('layout')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Templates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .rounded-img {
            border-radius: 25px;
            border-color: rgb(112, 114, 115); /* Sets the border color */
            border-width: 5px; /* Sets the border width */
            border-style: solid; /* Sets the border style */
            max-width: 100%; /* Ensures the image width doesn't exceed its container */
            max-height: 300px; /* Sets the maximum height to 300px */
            object-fit: contain; /* Ensures the entire image fits without cropping */
            transition: filter 0.3s ease; /* Smooth transition for image darkening */
        }

        .template-container {
            display: flex;
            flex-wrap: wrap;
            gap: 100px;
            background-color: rgb(186, 190, 194); /* Sets the background color */
            border-radius: 15px; /* Add rounded corners */
            padding: 20px; /* Optional: Add some padding to prevent the images from touching the edges */
            margin-top: 30px; /* Optional: Add some margin to separate from the header */
        }

        .template-card {
            text-align: center;
            width: 220px;
            position: relative; /* Ensures the label is positioned on top of the image */
        }

        .template-card label {
            display: block;
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color:rgb(71, 72, 72);
            text-align: center;
            text-transform: capitalize;
        }

        .image-container {
            position: relative;
        }

        .template-card:hover .rounded-img {
            filter: brightness(0.7);  /* Darkens the image */
        }

        .create-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 54px;
            font-weight: bold;
            color: white;
            opacity: 0;  /* Initially hidden */
            transition: opacity 0.3s ease;
        }

        .template-card:hover .create-text {
            opacity: 1;  /* Makes the text visible on hover */
        }

        /* Header and Search Bar container */
        .header-container {
            display: flex;
            justify-content: space-between; /* Space between header and search bar */
            align-items: center; /* Vertically align the header and search bar */
        }

        .search-bar {
            width: 300px; /* You can adjust the width as per your requirement */
            border-radius: 125px; /* Rounded corners for the search bar */
            overflow: hidden; /* Ensures the corners are rounded properly */
        }
    </style>
</head>
<body>
    <div class="container mt-0">
        <div class="header-container">
            <h1>Templates</h1>

            <!-- Search Box -->
            <div class="search-bar">
                <input type="text" class="form-control" placeholder="Search for a template" id="searchKeyword">
            </div>
        </div>

        <!-- Template Images -->
        <div class="template-container">
            <!-- Template 1 (Minimalist) -->
            <div class="template-card">
                <a href="{{ route('invoice.create', ['template' => 'minimalist']) }}">
                    <div class="image-container">
                        <img src="{{ asset('in_temp_pr/minimalist.jpg') }}" class="rounded-img" alt="Template 1">
                        <div class="create-text">Create</div>  <!-- "Create" label -->
                    </div>
                    <label>Minimalist</label>
                </a>
            </div>

            <!-- Template 2 (Modern) -->
            <div class="template-card">
                <a href="{{ route('invoice.create', ['template' => 'modern']) }}">
                    <div class="image-container">
                        <img src="{{ asset('in_temp_pr/modern.jpg') }}" class="rounded-img" alt="Template 2">
                        <div class="create-text">Create</div>  <!-- "Create" label -->
                    </div>
                    <label>Modern</label>
                </a>
            </div>
            <!-- Template 3 (Fancy) -->
            <div class="template-card">
                <a href="{{ route('invoice.create', ['template' => 'fancy']) }}">
                    <div class="image-container">
                        <img src="{{ asset('in_temp_pr/fancy.jpg') }}" class="rounded-img" alt="Template 3">
                        <div class="create-text">Create</div>  <!-- "Create" label -->
                    </div>
                    <label>Fancy</label>
                </a>
            </div>
            <!-- Template 4 (Chill) -->
            <div class="template-card">
                <a href="{{ route('invoice.create', ['template' => 'chill']) }}">
                    <div class="image-container">
                        <img src="{{ asset('in_temp_pr/chill.jpg') }}" class="rounded-img" alt="Template 4">
                        <div class="create-text">Create</div>  <!-- "Create" label -->
                    </div>
                    <label>Chill</label>
                </a>

            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@endsection
