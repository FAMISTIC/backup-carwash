// Place your JavaScript code here

// Example: Fetch data from an API and display it on the page
fetch('https://api.example.com/data')
  .then(response => response.json())
  .then(data => {
    // Process the retrieved data
    // Display the data on the page
    console.log(data);
  })
  .catch(error => {
    // Handle any errors that occurred during the fetch request
    console.error(error);
  });

// Example: Add event listeners to elements on the page
document.getElementById('button').addEventListener('click', function() {
  // Handle button click event
  console.log('Button clicked');
});

// Example: Perform form validation before submission
document.getElementById('myForm').addEventListener('submit', function(event) {
  // Prevent the form from submitting if validation fails
  event.preventDefault();

  // Perform form validation
  // ...

  // If validation passes, submit the form programmatically
  this.submit();
});

//----------------------------------------------------------------

function updatePrice() {
  var packageSelect = document.getElementById("package");
  var priceInput = document.getElementById("price");
  var selectedPackage = packageSelect.value;

  var price = 0;
  if (selectedPackage === "Basic") {
    price = 100;
  } else if (selectedPackage === "Premium") {
    price = 200;
  } else if (selectedPackage === "Deluxe") {
    price = 300;
  } else if (selectedPackage === "Supreme") {
    price = 400;
  }

  priceInput.value = price;
}
//----------------------------------------------------------------
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function myFunction2() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput2");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 3; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function myFunction3() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput3");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 2; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}