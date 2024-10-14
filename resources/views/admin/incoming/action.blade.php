<div class="d-flex flex-row gap-1">
    <button class="button-pay-installment btn btn-success d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;" {{ $total_installment == 0 ? 'disabled' : '' }}>
        <i class="fa-regular fa-dollar-sign text-green-900"></i>
    </button>
    <button class="button-show-installment btn btn-primary d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;" {{ $payment_type == 'cash' ? 'disabled' : '' }}>
        <i class="fa-regular fa-eye text-green-900"></i>
    </button>
    <button class="button-edit-product-incoming btn btn-warning d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
        <i class="fa-regular fa-pen-to-square text-green-900"></i>
    </button>
    <button class="button-delete-product-incoming btn btn-danger d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
        <i class="fa-regular fa-trash-can text-red-900"></i>
    </button>
</div>
