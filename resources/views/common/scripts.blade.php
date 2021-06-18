<script defer>
window.addEventListener('load', function() {

    //window.base_url = "{{URL::to('/')}}/";
    window.Laravel = {
        base_url : "{{URL::to('/')}}/",
        apiToken : "{{Auth::user()->api_token}}",
    };
});

</script>
