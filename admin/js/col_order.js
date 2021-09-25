
    $(function() {                      // Make Sortable Results for Columns to show
        $( "#sortableCols, #sortableCols2" ).sortable({
            connectWith: ".connectedSortable"
        }).disableSelection();
    });

    $(document).on('click', '.saveOrder', function() { // Save the order of columns to display
        var sortOrder = {};
        var i = 0;
        var name = false;
        $('#sortableCols li').each(function () {         // Precursor check, name must exist
            if ($(this).text() == 'Name') {
                name = true;
            }
        });
        if (name == false) {
            alert('You must at least keep "Name" in "Columns Used".');
            return false;
        }

        $('#sortableCols li').each(function () {         // Keepers
            i++;
            var id = $(this).attr('class').replace(/\D+/g,'');
            sortOrder[i] = {
                id: id,
                order: i,
                used: 1
            };
        });

        $('#sortableCols2 li').each(function () {        // Non Keepers
            i++;
            var id = $(this).attr('class').replace(/\D+/g,'');
            sortOrder[i] = {
                id: id,
                order: i,
                used: 0
            };
        });
        var type = 'saveOrder';
        var sortOrderString = JSON.stringify(sortOrder);
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "ajax/ajaxFunctions.php",
            data: {type: type, order: sortOrderString, token: token},
            success: function(response) {
                if (response.result == '1') {
                    $('#sortableCols').effect("highlight", {}, 3000);
                    $("#mymodal").css("display", "none");
                    window.location.href = "index.php";
                } else if (response.result == '2') {
                    alert(response.msg);

                } else {
                    alert('There was a problem with communication, please try again.');
                }
            }
        });
        return false;
    });
