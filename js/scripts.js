document.addEventListener("DOMContentLoaded", () => {
    fetch('data/cooks.json')
        .then(response => response.json())
        .then(data => {
            window.cooksData = data;
        })
        .catch(error => {
            console.error('Error fetching cooks data:', error);
        });
    
    const contributeForm = document.getElementById('contributeForm');
    if (contributeForm) {
        contributeForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            
            const formData = new FormData(this);
            
            // Perform form submission using fetch
            fetch('send_email.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                alert(result); // Alert the response
                this.reset(); // Reset the form
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
});

function searchCook() {
    const sector = document.getElementById('sector').value.toLowerCase();
    const cookList = document.getElementById('cookList');
    cookList.innerHTML = '';

    // Filter and display cooks based on selected sector
    window.cooksData.filter(cook => cook.sector.toLowerCase() === sector).forEach(cook => {
        const cookDiv = document.createElement('div');
        cookDiv.innerHTML = `
            <img src="${cook.photo}" alt="${cook.name}">
            <p>Name: ${cook.name}</p>
            <p>Gender: ${cook.gender}</p>
            <p>Mobile Number: ${cook.mobileNumber}</p>
        `;
        cookList.appendChild(cookDiv);
    });
}
