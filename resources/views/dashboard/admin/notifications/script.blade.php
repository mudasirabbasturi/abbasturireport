<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/pages/ui/dialogs.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        var table = $('#project_table').DataTable({
            order: [[1, 'desc']], 
       });

    });

    function goBack() {
        window.history.back();
    }

    const notifiTitleEles = document.getElementsByClassName('notifictionTitle');
    const notifiMsgEles = document.getElementsByClassName('notifictionMessage');

    for (let i = 0; i < notifiTitleEles.length; i++) {
        const ele = notifiTitleEles[i];
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

    for (let i = 0; i < notifiMsgEles.length; i++) {
        const ele = notifiMsgEles[i];
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

</script>