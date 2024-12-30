<div>
    @if ($message)
        <div id="success-message" class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
                {{ $message }}
            </div>

        </div>
    @endif

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('success-message-disappear', ({timeout}) => {
                console.log(timeout);

                setTimeout(() => {
                    const successMessage = document.getElementById('success-message');
                    if (successMessage) {
                        successMessage.remove();
                    }
                }, timeout || 5000);
            });
        });
    </script>
</div>
