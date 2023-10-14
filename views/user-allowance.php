<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
    <title>Allowance Page</title>
</head>

<style type="text/css">
    * {
        margin: 0px;
        padding: 0px;
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
        letter-spacing: 0.5px;
    }

    body {
        background-color: #092536;
    }

    button {
        background-color: #F99B3C;
        color: #051E2D;
        font-size: 15px;
        font-weight: 800;
        padding: 8px 40px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }

    button:hover {
        background-color: #BB742C;
    }

    .logo-div {
        width: 100%;
        padding-left: 1%;
        padding-right: 1%;
        min-height: 50px;
        line-height: 50px;
        background-color: #051E2D;
        border-bottom: 1px #054267 solid;
    }

    .body-div {
        width: 80%;
        margin-left: 10%;
        margin-right: 10%;
        min-height: 500px;
    }

    .body-top-div {
        display: flex;
        width: 100%;
        margin-bottom: 10px;
        min-height: 60px;
        font-size: 25px;
        align-items: flex-end;
        border-bottom: 1px #054267 solid;
    }

    .list-div {
        width: 67%;
        min-height: 400px;
        float: left;
    }

    .list-header-div {
        display: flex;
        width: 100%;
        min-height: 60px;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        margin-top: 10px;
    }

    .list-body-div {
        width: 100%;
        min-height: 500px;
        background-color: #124361;
        border-radius: 10px;
    }

    .info-div {
        width: 30%;
        min-height: 400px;
        float: right;
    }

    .logo-text {
        color: #F99B3C;
        font-size: 20px;
        font-style: normal;
        font-weight: 900;
    }

    .primary-text {
        color: #B5E3FF;
        font-size: 25px;
        font-style: normal;
        font-weight: 700;
    }

    .secondary-text {
        color: #B5E3FF;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
    }

    .italic-text {
        color: #B5E3FF;
        font-size: 14px;
        font-weight: normal;
        font-style: italic;
        margin-top: 10px
    }
</style>

<body>
    <div class="logo-div logo-text">
        Money minder
    </div>
    <div class="body-div logo-text">
        <div class="body-top-div primary-text">
            User
        </div>
        <div class="list-div">
            <div class="list-header-div">
                <div class="secondary-text">
                    Allowance list
                </div>
                <div>
                    <button>
                        New allowance
                    </button>
                </div>
            </div>
            <div class="list-body-div">

            </div>
        </div>
        <div class="info-div secondary-text" style="margin-top: 10px">
            Allowance info
            <h1 class="italic-text" style="margin-top: 30px"> House rent allowance</h1>
            <h1 class="italic-text" style="font-weight: lighter">This allowance is only for monthly rent.</h1>
        </div>
    </div>
</body>

</html>