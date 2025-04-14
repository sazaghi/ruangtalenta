<style>
    .card-custom {
        width: 200px; /* Lebar card */
        height: 100px;
        border-radius: 1rem;
        background-color: white;
        position: relative; /* Agar pseudo-element dapat diposisikan relatif terhadap card */
        padding: 12px 16px;
        transition: transform 0.2s ease;
    }

    /* Pseudo-element untuk shadow */
    .card-custom::after {
        content: "";
        position: absolute;
        top: 10px; /* Posisi sedikit di bawah card */
        left: 10px; /* Posisi sedikit ke kiri */
        width: calc(100% - 50px); /* Lebar lebih kecil dari card */
        height: 100px; /* Tinggi sama dengan card */
        background-color: rgba(172, 181, 194, 0.9); /* Warna shadow */
        border-radius: 1rem; /* Sama dengan border-radius card */
        z-index: -1; /* Pastikan shadow berada di belakang card */
    }

    .icon-circle {
        background-color: #FDBA3F;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
    }

    .icon-circle i {
        font-size: 20px;
        color: black;
    }

    .bg-dashboard {
        background-color: #6B74B5;
    }

    .card-text-section {
        font-size: 12px;
        color: #6c757d;
    }

    .card-value {
        font-size: 30px;
        font-weight: 500;
    }

    .card-margin-start {
        margin-left: 20px;
    }

    .card-margin-end {
        margin-right: 20px;
    }
</style>

<div class="d-flex justify-content-center align-items-center bg-dashboard py-4 my-1">
    <!-- Card 1 -->
    <div class="card-custom card-margin-start me-3">
        <div class="card-value">10</div>
        <div class="card-text-section">Posted Job</div>
        <div class="icon-circle">
            <i class="bi bi-person"></i>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="card-custom me-3">
        <div class="card-value">80</div>
        <div class="card-text-section">Interview Schedule</div>
        <div class="icon-circle">
            <i class="bi bi-bookmark"></i>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="card-custom me-3">
        <div class="card-value">1.9k</div>
        <div class="card-text-section">Application</div>
        <div class="icon-circle">
            <i class="bi bi-eye"></i>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="card-custom card-margin-end">
        <div class="card-value">05</div>
        <div class="card-text-section">Save Candidate</div>
        <div class="icon-circle">
            <i class="bi bi-pencil"></i>
        </div>
    </div>
</div>
