@php
    $fileName = 'document_' . now()->timestamp . '.pdf';
@endphp

<a href="data:application/pdf;base64,{{ $pdfData }}" download="{{ $fileName }}" class="btn">
    <img src="{{ asset('download-pdf.png') }}" alt="PDF letöltése">
</a>

<style scoped>
img {
    width: 110px;
    
}
</style>