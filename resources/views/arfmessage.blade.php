@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css?family=Lato|Roboto+Slab');

* {
  position: relative;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.centered {
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

h1 {
  margin-bottom: 10px;
  font-family: 'Lato', sans-serif;
  font-size: 50px;
}

.message {
  display: inline-block;
  line-height: 1.2;
  transition: line-height .2s, width .2s;
  overflow: hidden;
}

.message,
.hidden {
  font-family: 'Roboto Slab', serif;
  font-size: 18px;
}

.hidden {
  color: #FFF;
}

#btnClose {
    margin: auto;
    display: block;
}

button {
  font-family: 'Muli', sans-serif;
  -webkit-transition: 0.15s all ease-in-out;
  -o-transition: 0.15s all ease-in-out;
  transition: 0.15s all ease-in-out;
  cursor: pointer; }

.all {
  padding: 30px 0;
  margin: 0 auto;
  width: 90%;
  height: auto;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
  -ms-flex-pack: justify;
  justify-content: space-between;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center; }

.buttons {
  width: 80%;
  margin: 0 auto;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
  -ms-flex-pack: justify;
  justify-content: space-between;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center; }

.one {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center; }

.curve {
  background: #0069eb;
  color: #fff;
  border-radius: 6px;
  border: none;
  font-size: 16px;
  padding: 15px 30px;
  text-decoration: none; }
</style>

<section class="centered">
  <h1 style="color: {{ isset($color) ? $color : '#777' }}">{{ isset($title) ? $title : 'Error' }}</h1>
  <div class="container text-center">
    <span class="message" id="js-whoops"></span> 
    <span class="message" id="js-appears"></span> 
    <span class="message" id="js-error"></span> 
    <span class="message" id="js-apology"></span>
    <div><span id="js-hidden" style="color: {{ isset($color) ? $color : '#777' }}">{{ isset($message) ? $message : 'Some Error Occured.' }}</span></div>
  </div>
</section>

@endsection