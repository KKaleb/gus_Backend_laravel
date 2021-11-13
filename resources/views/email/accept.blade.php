@component('mail::message')

    # Gulder Ultimate Search...<br><br>
<img src="https://gus-media-files.s3.eu-west-3.amazonaws.com/49ca192d-427e-4b96-9712-e61bf11810e5.png" height="300">

<br>
Dear {{$first_name}} {{$last_name}},<br>
Congratulations! You have been shortlisted for the regional selection screening exercise of the Gulder Ultimate Search "Age of Craftmanship".
Please find details below:
    <br>
<br>
DATE: {{$date}}<br>
VENUE:  {{$address}}, {{$venue}} <br>
TIME: {{$time}}<br>
BATCH: Batch {{$batch}}<br>
    <br><br>
BARCODE:
<img src="{{$barcode}}">

Note:<br>
Please ensure you are punctual. Failure to do may lead to disqualification. <br>
Bring this email, barcode, and national means of identification with you to the venue. <br>
Come prepared with your sportwear, sport shoes and swimwear as your audition will include physical activities.
<br>
<br>
<br>
The GUS Team.

@endcomponent
