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
//----------------------------------------------------------------
function addColumn() {
  var container = document.getElementById("input-container");
  var inputs = container.getElementsByTagName("input");

  if (inputs.length < 5) {
      var input = document.createElement("input");
      input.type = "text";
      input.name = "columns[]";
      input.placeholder = "Column";
      container.appendChild(input);
  }
}

function removeColumn() {
  var container = document.getElementById("input-container");
  var inputs = container.getElementsByTagName("input");

  if (inputs.length > 1) {
      container.removeChild(inputs[inputs.length - 1]);
  }
}

function addTableInput() {
  var tableContainer = document.getElementById('table-container');
  var tableInputs = tableContainer.getElementsByTagName('input');

  if (tableInputs.length < 5) {
      var tableInput = document.createElement('input');
      tableInput.type = 'text';
      tableInput.name = 'tables[]';
      tableInput.placeholder = 'Table';
      tableContainer.appendChild(tableInput);
  }
}

function removeTableInput() {
  var tableContainer = document.getElementById('table-container');
  var tableInputs = tableContainer.getElementsByTagName('input');
  if (tableInputs.length > 0) {
      tableContainer.removeChild(tableInputs[tableInputs.length - 1]);
  }
}

//----------------------------------------------------------------

function validateForm() {
  var columnInputs = document.getElementsByName('columns[]');
  var numColumns = columnInputs.length;

  // Check if any column inputs are empty
  for (var i = 0; i < numColumns; i++) {
      if (columnInputs[i].value === '') {
          alert('Please fill in all column names.');
          return false;
      }
  }

  return true;
}