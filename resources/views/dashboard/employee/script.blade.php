<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>    
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/pages/ui/dialogs.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    function goBack() {window.history.back();}
    $(document).ready(function () {
        var table = $('#project_table').DataTable();
        // Run the time indicator code for the current page
        updateAllTimeIndicators(table);
        // Listen for the "page.dt" event and re-run the time indicator code for the new page
        table.on('page.dt', function () {
            updateAllTimeIndicators(table);
        });

    });
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
    // Action Scripts 
    var btnGoInEle = document.getElementsByClassName('btn-goIn')
    for (i = 0; i < btnGoInEle.length; i++) {
        var btnClicked = btnGoInEle[i];
        btnClicked.addEventListener('click', function () {
            var prjIdEle = document.getElementById('project_id')
            var UsrIdEle = document.getElementById('user_id');
            var pid = this.dataset.projectid
            var uid = this.dataset.userid
            prjIdEle.value = pid
            UsrIdEle.value = uid
        })
    }
    var btnGoUpdEle = document.getElementsByClassName('btnGoUpd')
    for (i = 0; i < btnGoUpdEle.length; i++) {
        var btnClicked = btnGoUpdEle[i];
        btnClicked.addEventListener('click', function () {
            var actionId = this.dataset.id
            var url = "{{route('action.show', ['action' => ':id'])}}".replace(':id', actionId)
            const actionUpdatexhttp = new XMLHttpRequest()
            actionUpdatexhttp.onload = function () {
                var response = JSON.parse(this.responseText);
                var checkboxes = '';
                if (response.hasOwnProperty('message')) {
                    checkboxes = '<p>' + response['message'] + '</p>';
                } else {
                    for (var key in response) {
                        checkboxes += '<div class="fancy-checkbox">';
                        checkboxes += '<label>';
                        checkboxes += '<input type="checkbox" name="' + key + '" value="' + response[key] + '">';
                        checkboxes += '<span>' + response[key] + '</span>';
                        checkboxes += '</label>';
                        checkboxes += '</div>';
                    }
                }
                document.getElementById('updateChceckboxes').innerHTML = checkboxes;
            }
            actionUpdatexhttp.open("GET", url);
            actionUpdatexhttp.send();

            var updateFormEle = document.getElementById('actionUpdateForm')
            updateFormEle.action = "{{route('action.showUpdate', ['id' => ':id'])}}".replace(':id', actionId)
        })
    }
    var completeActionEle = document.getElementsByClassName('completeAction')
    for (i = 0; i < completeActionEle.length; i++) {
        var btnClicked = completeActionEle[i];
        btnClicked.addEventListener('click', function () {
            var projectID = this.dataset.projectid
            document.getElementById('proCompletForm').action = "{{ route('action.complete',['id' => ':id']) }}".replace(':id', projectID)
        })
    }
    // Action Percemt
    var btnPerEle = document.getElementsByClassName('percentAction')
    for (i = 0; i < btnPerEle.length; i++) {
        var btnClick = btnPerEle[i]
        btnClick.addEventListener('click', function () {
            var actionID = this.dataset.aid
            var projectID = this.dataset.pid
            var userID = this.dataset.uid
            // action.percent
            var url = "{{ route('action.percent', ['id' => ':id']) }}".replace(':id', actionID)
            const pxhttp = new XMLHttpRequest()
            pxhttp.onload = function () {
                var response = JSON.parse(this.responseText);
                var data = response.data
                var perc = response.percent
                var inputGroups = '';
                var percetGroups = '';
                for (var key in data) {
                    inputGroups += '<div class="input-group mb-3 input-group-sm">';
                    inputGroups += '<div class="input-group-prepend">';
                    inputGroups += '<span class="input-group-text"> ' + data[key] + '</span>';
                    inputGroups += '</div>';
                    inputGroups += '<input type="number" class="form-control" placeholder="Enter ' + data[key] + ' percent" name="' + data[key] + '" value ="" min="0" max="100">';
                    inputGroups += '</div>';
                }
                for (var key in perc) {
                    percetGroups += '<div class="progress mb-1" style="background: #dee2e6;">';
                    percetGroups += '<div class="progress-bar bg-success text-dark" style="width:' + perc[key] + '%">' + key + ': ' + perc[key] + ' %</div>';
                    percetGroups += '</div>';
                }
                document.getElementById('per_container').innerHTML = inputGroups;
                document.getElementById('per_header_container').innerHTML = percetGroups;
                document.getElementById('percent-form').action = '{{ route("action.update", ":id") }}'.replace(':id', actionID);
            }
            pxhttp.open("GET", url);
            pxhttp.send();
        })
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

    const proAddressEles = document.getElementsByClassName('projectAddress');
    for (let i = 0; i < proAddressEles.length; i++) {
        const eleAddress = proAddressEles[i];
        const textAddress = eleAddress.textContent.trim();
        if (textAddress.length > 15) {
            eleAddress.textContent = textAddress.substr(0, 15).trim() + '...';
        }
    }


    // Get all elements with class 'project_title'
    const proTitleEles = document.getElementsByClassName('project_title');
    for (let i = 0; i < proTitleEles.length; i++) {
        const eleTitle = proTitleEles[i];
        const textTitle = eleTitle.textContent.trim();
        if (textTitle.length > 15) {
            eleTitle.textContent = textTitle.substr(0, 15).trim() + '...';
        }
    }
    
</script>