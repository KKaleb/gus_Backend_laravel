@component('mail::message')

    #  Gulder Ultimate Search...<br><br>

    Dear {{$first_name}} {{$last_name}},<br>
    Congratulations! You have been shortlisted for the regional selection screening exercise.
    Please find below the venue and your special access code number.
    <br>
    VENUE: {{$venue}} <br>
    BARCODE: {{$code}}  <br>
    BATCH: A <br>
    TIME: 9 am prompt.<br>
    <br><br>
    <b>The Council of Elders</b>
@endcomponent

