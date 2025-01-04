
$(document).ready(function () {
const allElements = document.querySelectorAll('.dynamic')
for (let i = 0; i < allElements.length; i++) {
    $(allElements[i]).on('change',function(){
        if ($(this).val() != '') {

            var select = $(this).attr("name");
            var value = $(this).val();
            var dependent = $(this).data('dependent');
            var _token = $('input[name="_token"]').val();
            var elementId = $(this).attr("id");

            
            console.log(dependent);
            $.ajax({
                url: "/clubs/dynamic",
                method: "POST",
                data: { select: select, value: value, _token: _token, dependent: dependent },
                success: function (result) {
                    $('#' + elementId + 'a').html(result);
                }
            })
        }
    })
}
})
