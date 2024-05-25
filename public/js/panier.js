// public/js/bucket.js

function updateBucketCount() {
    const bucketCountElement = document.getElementById('bucketCount');
    const bucket = JSON.parse(localStorage.getItem('bucket')) || [];
    const itemCount = bucket.reduce((count, item) => count + item.quantity, 0);
    if (bucketCountElement) {
        bucketCountElement.textContent = itemCount;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    updateBucketCount();
});
