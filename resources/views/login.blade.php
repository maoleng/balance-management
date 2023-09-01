<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TDT Tool</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }
        body {
            height: 100vh;
            width: 100vw;
            background: #18191f;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100vw;
            flex-direction: column;

        }
        #google{
            font-size: 16em;
            background-color: #18191f;
            color: #fff;
            box-shadow: 2px 2px 2px #00000080, 10px 1px 12px #00000080,
            2px 2px 10px #00000080, 2px 2px 3px #00000080, inset 2px 2px 10px #00000080,
            inset 2px 2px 10px #00000080, inset 2px 2px 10px #00000080,
            inset 2px 2px 10px #00000080;
            border-radius: 29px;
            padding: 11px 19px;
            margin: 0 40px;
            animation: animate 0.9s linear infinite;
            text-shadow: 0 0 50px #0072ff, 0 0 100px #0072ff, 0 0 150px #0072ff,
            0 0 200px #0072ff;
        }
        #google {
            animation-delay: 0.3s;
        }

        @keyframes animate {
            from {
                filter: hue-rotate(0deg);
            }
            to {
                filter: hue-rotate(360deg);
            }
        }

    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<div class="container">
    <a href="{{route('redirect')}}">
        <i class="fa fa-google" id="google"></i>
    </a>

</div>

</body>

</html>
