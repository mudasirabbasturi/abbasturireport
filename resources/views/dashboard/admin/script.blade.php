<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/pages/ui/dialogs.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>

$(document).ready(function () {
    var table = $('#project_table').DataTable({
        order: [[1, 'desc']], // Assuming the first column is the date column
});

    // Run the time indicator code for the current page
    updateAllTimeIndicators(table);

    table.on('draw.dt', function () {
        updateAllTimeIndicators(table);
    });


    // Get all buttons
    var buttons = document.querySelectorAll('.btn-filter');

    // Attach click event listener to each button
    buttons.forEach(button => {
    button.addEventListener('click', function() {
        var dataTarget = this.getAttribute('data-target');

        // Set the value of the search input
        var searchInput = document.querySelector('.dataTables_filter input');
        searchInput.value = dataTarget;

        // Focus on the search input
        searchInput.focus();

        // Trigger keyup event
        var event = new Event('keyup');
        searchInput.dispatchEvent(event);

        // Filter based on the modified search behavior
        table.column(0).search(dataTarget, true, false).draw();
    });
});

});

    function goBack() {
        window.history.back();
    }

    function updateAllTimeIndicators(table) {
        table.$('.time_indicator').each(function () {
            var dueDateStr = $(this).data('due-date');
            var dueDate = new Date(dueDateStr);
            setInterval(function () {
                var now = new Date();
                var diffMs = dueDate - now;
                if (diffMs < 0) {
                    $(this).find('.days').text("00");
                    $(this).find('.hours').text("00");
                    $(this).find('.minutes').text("00");
                    $(this).find('.seconds').text("00");
                    $(this).addClass("text-danger");
                    return;
                }
                var diffDays = Math.floor(diffMs / 86400000);
                var diffHrs = Math.floor((diffMs % 86400000) / 3600000);
                var diffMins = Math.floor(((diffMs % 86400000) % 3600000) / 60000);
                var diffSecs = Math.floor((((diffMs % 86400000) % 3600000) % 60000) / 1000);
                $(this).find('.days').text(diffDays.toString().padStart(2, '0'));
                $(this).find('.hours').text(diffHrs.toString().padStart(2, '0'));
                $(this).find('.minutes').text(diffMins.toString().padStart(2, '0'));
                $(this).find('.seconds').text(diffSecs.toString().padStart(2, '0'));
            }.bind(this), 1000);
        });
    }

    var projRprEle = document.getElementsByClassName("report")
    for (i = 0; i < projRprEle.length; i++) {
        btnClicked = projRprEle[i]
        btnClicked.addEventListener('click', EmployeeReport)
    }
    function EmployeeReport() {
        actionId = this.dataset.aid
        var url = "{{ route('report.show', ['id' => ':id']) }}".replace(':id', actionId)

        var imageSrc = this.querySelector('img').getAttribute('src');
        var userName = this.querySelector('img').getAttribute('alt');

        // set the image source and user name in the modal

        document.getElementById('user_task_image').setAttribute('src', imageSrc);
        document.getElementById('userName').textContent = userName;

        const xhttp = new XMLHttpRequest()
        xhttp.onload = function () {
            var response = JSON.parse(this.responseText);
            var data = response.data
            var perc = response.percent
            var percetGroups = '';
            for (var key in perc) {
                percetGroups += '<div class="progress mb-1" style="background: #dee2e6;">';
                percetGroups += '<div class="progress-bar bg-success text-dark" style="width:' + perc[key] + '%">' + key + ': ' + perc[key] + ' %</div>';
                percetGroups += '</div>';
            }
            document.getElementById('user_task_report').innerHTML = percetGroups;
            //document.getElementById('user_task_image').setAttribute('src', imageSrc);
        }
        xhttp.open("GET", url);
        xhttp.send();
    }

    // status action scrips
    var StatusActionEle = document.getElementsByClassName("status_actions")
    var StatusActionForm = document.getElementById("status_action_form")
    var checkboxes = Array.from(document.querySelectorAll('#checkbox_wrapper input[type="checkbox"]'));
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            if (this.checked) {
                checkboxes.filter(function (cb) { return cb !== checkbox; }).forEach(function (cb) { cb.disabled = true; });
                timeStartBtn.disabled = false;
            } else {
                checkboxes.forEach(function (cb) { cb.disabled = false; });
                timeStartBtn.disabled = true;
            }
        });
    });

    for (i = 0; i < StatusActionEle.length; i++) {
        btnClicked = StatusActionEle[i]
        btnClicked.addEventListener('click', function () {
            var id = this.dataset.id
            var url = "{{ route('adminActionStatus.update',['id' => ':id'])}}".replace(':id', id)
            StatusActionForm.action = url
        })
    }

    const proAddressEles = document.getElementsByClassName('projectAddress');
    for (let i = 0; i < proAddressEles.length; i++) {
        const eleAddress = proAddressEles[i];
        const textAddress = eleAddress.textContent.trim();
        if (textAddress.length > 30) {
            eleAddress.textContent = textAddress.substr(0, 30).trim() + '...';
        }
    }


    // Get all elements with class 'project_title'
    const proTitleEles = document.getElementsByClassName('project_title');
    for (let i = 0; i < proTitleEles.length; i++) {
        const eleTitle = proTitleEles[i];
        const textTitle = eleTitle.textContent.trim();
        if (textTitle.length > 30) {
            eleTitle.textContent = textTitle.substr(0, 30).trim() + '...';
        }
    }

    // Get all elements with class 'main_scope'
    const mainScopeEles = document.getElementsByClassName('main_scope');

    // Loop through each element and update its text content
    for (let i = 0; i < mainScopeEles.length; i++) {
        const ele = mainScopeEles[i];
        const text = ele.textContent;

        // If the length of the text is greater than 25
        if (text.length > 25) {
            ele.style.cursor = "zoom-in"
            // Show only the first 25 characters followed by '...'
            ele.textContent = text.substr(0, 25) + '...';

            // Add a click event listener to toggle the full text
            ele.addEventListener('click', function () {
                if (ele.textContent === text) {
                    ele.textContent = text.substr(0, 25) + '...';
                } else {
                    ele.textContent = text;
                }
            });
        }
    }
    const copyLink = document.getElementById('copyLink');
        
        copyLink.addEventListener('click', function(event) {
            event.preventDefault();
            const url = this.getAttribute('data-url');
            
            navigator.clipboard.writeText(url)
                .then(() => {
                    // URL copied successfully
                    // You can add any additional handling here
                    console.log('URL copied to clipboard:', url);
                })
                .catch((error) => {
                    // Failed to copy URL
                    // You can add any error handling here
                    console.error('Error copying URL to clipboard:', error);
                });
        });

</script>

{{-- <script>

    const buttons = document.querySelectorAll('.btn-filter');
  
    buttons.forEach(button => {
      button.addEventListener('click', function() {
        const dataTarget = this.getAttribute('data-target');
        const searchInput = document.querySelector('.dataTables_filter input');
        searchInput.value = dataTarget;
        searchInput.focus();
        const event = new Event('keyup');
        searchInput.dispatchEvent(event);
        table.column(0).search(dataTarget, true, false).draw();
      });
    });


</script> --}}