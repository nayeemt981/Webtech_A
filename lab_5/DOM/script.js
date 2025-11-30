// 1. Event Listener for Form Submission
document.getElementById('student-form').addEventListener('submit', addStudent);

// 2. Add Student Function
function addStudent(event) {
    event.preventDefault(); // Stop form from refreshing

    // 3. Get input value
    let studentName = document.getElementById('student-name').value;

    if (studentName === '') {
        alert('Please enter a student name');
        return; // stop if empty
    }

    // 4. Create <li> for student
    let li = document.createElement('li');
    li.classList.add('student-item');

    // 5. Create span for name
    let span = document.createElement('span');
    span.textContent = studentName;

    // 6. Create Edit Button
    let editButton = document.createElement('button');
    editButton.textContent = 'Edit';
    editButton.addEventListener('click', function () {
        editStudent(li, span);
    });

    // Create Delete Button
    let deleteButton = document.createElement('button');
    deleteButton.textContent = 'Delete';
    deleteButton.addEventListener('click', function () {
        deleteStudent(li);
    });

    // Add items to <li>
    li.appendChild(span);
    li.appendChild(editButton);
    li.appendChild(deleteButton);

    // 7. Append to list
    document.getElementById('student-list').appendChild(li);

    // Clear input box
    document.getElementById('student-name').value = '';
}

// 8. Delete Student Function
function deleteStudent(studentElement) {
    studentElement.remove();
}

// 9. Edit Student Function
function editStudent(studentElement, studentNameElement) {
    let newName = prompt('Enter the new name:', studentNameElement.textContent);

    if (newName !== null && newName !== '') {
        studentNameElement.textContent = newName;
    }
}

// 10. Change List Style Function
function changeListStyle() {
    let students = document.querySelectorAll('.student-item');

    students.forEach(student => {
        student.classList.toggle('highlight');
    });
}

// 11. Add Highlight Toggle Button
let changeStyleButton = document.createElement('button');
changeStyleButton.textContent = 'Highlight Students';
changeStyleButton.addEventListener('click', changeListStyle);
document.body.appendChild(changeStyleButton);
