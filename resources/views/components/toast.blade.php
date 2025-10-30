<div>
    <script>
        document.addEventListener('notify', function (event) {
            const { variant = event?.detail[0]?.variant, message = event?.detail[0]?.message } = event?.detail[0];

            if (window.notyf) {
                window.notyf.dismissAll();
                switch (variant) {
                    case 'success':
                        window.notyf.success({ message, duration: 3000 });
                        break;
                    case 'danger':
                        window.notyf.error({ message, duration: 3000 });
                        break;
                    case 'warning':
                        window.notyf.open({ type: 'warning', background: 'orange', message, duration: 3000, dismissible: true });
                        break;
                    case 'info':
                        window.notyf.open({ type: 'info', background: 'blue', message, duration: 3000 });
                        break;
                    default:
                        window.notyf.open({ type: 'default', background: 'gray', message, duration: 3000 });
                        break;
                }
            } else {
                console.error('Notyf is not initialized.');
            }
        });
    </script>
</div>
