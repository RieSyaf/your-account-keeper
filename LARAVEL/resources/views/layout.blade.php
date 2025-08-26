
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account Keeper.</title>


    
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Include Custom CSS -->
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">



    <style>
        body {
            background-color: rgb(112, 114, 115) !important;
        }

        h1 {
            font-family: Times New Roman !important;
            font-size: 70px !important;
            text-align: left;
            color: rgb(204, 211, 214) !important;
        }
        h3 {
            font-family: Times New Roman !important;
            text-align: center;
            color: rgb(112, 114, 115) !important;
            font-weight: bold; /* Added to make it bold */
        }
        h5 {
            font-family: Times New Roman !important;
            text-align: center;
            color: rgb(112, 114, 115) !important;
            font-weight: bold; /* Added to make it bold */
            
        }

    </style>
</head>
<body>
    <!-- Include Navbar -->
    @include('navbar')
    
    
    <!-- Include Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Include Custom JS -->
    <script src="{{ asset('js/navbar.js') }}"></script>
    
</body>
</html>
