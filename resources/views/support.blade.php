<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Support</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Styles -->
    </head>
    <body>
      <div class="container">
          <div class="row">
              <div class="col-md-12 mt-4">
                <form action="/" method="GET">
                  <div class="form-group">
                    <input
                      type="text"
                      name="search"
                      class="form-control"
                      placeholder="Search"
                      required
                      value={{ $question }}
                    >
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">Search</button>
                </form>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12 mt-4">
              @if (count($answers) > 0)
                @foreach ($answers as $themeName => $themeAnswers)
                  <h2>Theme: {{ $themeName }}</h2>
                  @foreach ($themeAnswers as $answer)
                    <h3>Symptom: {{ $answer['symptom'] }}</h3>
                    <ul class="list-group mb-4">
                    @foreach ($answer['solutions'] as $solution)
                      <li class="list-group-item">{{ $solution }}</li>
                    @endforeach
                    </ul>
                  @endforeach
                @endforeach
              @endif
              </div>
          </div>
      </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>
