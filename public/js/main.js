$(document).ready(function() {
    $('.btn-delete').on('click', function() {
        const productId = $(this).data('id');
        const row = $(this).closest('tr');

        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: '/products/delete',
                type: 'POST',
                data: { id: productId },
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        row.remove();
                        alert('Product deleted successfully!');
                    } else {
                        alert('Error deleting product.');
                    }
                },
                error: function() {
                    alert('An error occurred.');
                }
            });
        }
    });
});