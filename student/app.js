// Sample data for clearance requirements
const departmentRequirements = [
  "Department Form",
  "Transcript",
  "Course Completion Letter",
];
const facultyRequirements = ["Faculty Form", "Payment Receipt"];
const adminRequirements = [
  "Admin Block Form",
  "Final Year Project Approval",
  "Library Clearance",
];

// Attach event listeners for buttons
document.getElementById("departmentBtn").addEventListener("click", function () {
  loadClearanceForm("Department", departmentRequirements);
});
document.getElementById("facultyBtn").addEventListener("click", function () {
  loadClearanceForm("Faculty", facultyRequirements);
});
document.getElementById("adminBtn").addEventListener("click", function () {
  loadClearanceForm("Admin Block", adminRequirements);
});

// Function to dynamically generate the clearance form
function loadClearanceForm(category, requirements) {
  const formSection = document.getElementById("clearanceFormSection");
  formSection.innerHTML = `
        <h4>Submit Clearance for ${category}</h4>
        <form id="${category.toLowerCase()}ClearanceForm">
            <table class="table">
                <thead>
                    <tr>
                        <th>Document Name</th>
                        <th>Upload</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="documentList">
                    ${requirements
                      .map((req) => generateDocumentRow(req))
                      .join("")}
                </tbody>
            </table>
        </form>
    `;
  attachDocumentActions();
}

// Function to generate a row for each document requirement
function generateDocumentRow(documentName) {
  return `
        <tr class="document-row">
            <td class="document-name">${documentName}</td>
            <td>
                <button class="upload-btn" onclick="uploadDocument('${documentName}')">Upload</button>
            </td>
            <td>
                <span class="view-btn">View</span>
                <span class="delete-btn">Delete</span>
            </td>
        </tr>
    `;
}

// Mock upload document function
function uploadDocument(documentName) {
  alert(`Uploading ${documentName}`);
  // Handle file upload functionality here
}

// Attach event listeners to dynamically generated view and delete buttons
function attachDocumentActions() {
  document.querySelectorAll(".view-btn").forEach((button) => {
    button.addEventListener("click", function () {
      alert("View document clicked!");
      // Add logic to view the document
    });
  });

  document.querySelectorAll(".delete-btn").forEach((button) => {
    button.addEventListener("click", function () {
      this.closest("tr").remove(); // Remove the document row
    });
  });
}

// view notfication
// Sample notification data
const notifications = [
  {
    step: "Dean Clearance",
    description: "Your clearance with the Dean has been approved.",
    status: "approved",
    date: "2024-10-01",
  },
  {
    step: "Faculty Clearance",
    description: "Your faculty clearance is still pending.",
    status: "pending",
    date: "2024-09-30",
  },
  {
    step: "Library Clearance",
    description: "Your library clearance has been approved.",
    status: "approved",
    date: "2024-09-25",
  },
  {
    step: "Admin Block Clearance",
    description: "Admin Block clearance is pending.",
    status: "pending",
    date: "2024-09-28",
  },
];
