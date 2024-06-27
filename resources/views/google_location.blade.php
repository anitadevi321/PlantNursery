<!DOCTYPE html>
<html>
<head>
    <title>Google Places Autocomplete Example</title>
</head>
<body>
    <div>
        <label for="location">Location:</label>
        <input id="location" type="text" />
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWpq2PM4WLUbrF0-ThnEAkC4ZJcxkyxyo&libraries=places"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var autocomplete;
            var id = 'location';
            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById(id),
                { types: ['geocode'] }
            );
        });
    </script>
</body>
</html>
