@component('mail::message')

    # Welcome to Gulder Ultimate Search...<br><br>
<img src="https://gus-media-files.s3.eu-west-3.amazonaws.com/49ca192d-427e-4b96-9712-e61bf11810e5.png" height="300">
<br><br><br>
Dear {{$name}}<br><br>
Please use the code below to verify your email<br>
<h1>{{$code}}</h1>
Thanks
<br>
<br>
    {{--<b>The Council of Elders</b>--}}

@endcomponent
