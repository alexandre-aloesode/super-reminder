const toDoTasks = document.querySelector("#toDoTasks");
const currentTasks = document.querySelector("#currentTasks");
const doneTasks = document.querySelector("#doneTasks");
document.querySelector("#addTaskIcon").addEventListener("click", displayAddTaskDiv);
document.querySelector("#addTaskButton").addEventListener("click", addTask);
document.querySelector("#closeAddTaskDivBtn").addEventListener("click", closeAddTaskDiv);
document.querySelector("#closeTaskDivBtn").addEventListener("click", closeTaskDetails);
let destinationDiv = "";
let dragged;
let taskId;

async function getUserTasks() {
  const reqTasks = new FormData();
  reqTasks.append("action", "getTasks");

  const requestOptions = {
    method: "POST",
    body: reqTasks,
  };

  let userTasks = await fetch("../../back/Controller/taskController.php", requestOptions);
  userTasks = await userTasks.json();

  if (userTasks.success == true) {
    for (let task of userTasks.tasks) {
      displayTask(task);
    }
  }
}

toDoTasks.addEventListener(
  "dragover",
  (event) => {
    event.preventDefault();
    destinationDiv = event.toElement.id;
  },
  false
);

currentTasks.addEventListener(
  "dragover",
  (event) => {
    event.preventDefault();
    destinationDiv = event.toElement.id;
  },
  false
);

doneTasks.addEventListener(
  "dragover",
  (event) => {
    event.preventDefault();
    destinationDiv = event.toElement.id;
  },
  false
);

function displayTask(task) {
  let singleTask = document.createElement("div");
  singleTask.setAttribute("class", "singleTaskDiv");
  singleTask.setAttribute("draggable", "true");
  let singleTaskTitle = document.createElement("h3");
  singleTaskTitle.innerHTML = `${task.title}`;
  singleTask.appendChild(singleTaskTitle);
  let singleTaskDetailsDiv = document.createElement("div");
  singleTaskDetailsDiv.setAttribute("class", "singleTaskDetailsDiv");
  singleTask.appendChild(singleTaskDetailsDiv);
  let singleTaskDescription = document.createElement("p");
  singleTaskDescription.innerHTML = `${task.description}`;
  singleTaskDetailsDiv.appendChild(singleTaskDescription);
  let deleteTaskIcon = document.createElement("i");
  deleteTaskIcon.setAttribute("class", "fa-regular fa-circle-xmark");
  deleteTaskIcon.addEventListener("click", () => {
    deleteTask(task.id);
  });
  singleTask.appendChild(deleteTaskIcon);

  singleTask.addEventListener("click", () => {
    displayTaskDetails(task);
  });

  singleTask.addEventListener(
    "dragstart",
    (e) => {
      dragged = e.target;
      e.target.classList.add("dragging");
    },
    false
  );

  singleTask.addEventListener(
    "dragover",
    (event) => {
      event.preventDefault();
      destinationDiv = event.toElement.parentElement.id;
    },
    false
  );

  singleTask.addEventListener(
    "dragend",
    (e) => {
      e.target.classList.remove("dragging");
      if (destinationDiv == "toDoTasks") {
        updateTaskStatus(task.id, "to_do");
        toDoTasks.appendChild(dragged);
      } else if (destinationDiv == "currentTasks") {
        updateTaskStatus(task.id, "current");
        currentTasks.appendChild(dragged);
      } else if (destinationDiv == "doneTasks") {
        updateTaskStatus(task.id, "done");
        doneTasks.appendChild(dragged);
      }
    },
    false
  );

  if (task.status == "to_do") {
    toDoTasks.appendChild(singleTask);
  } else if (task.status == "current") {
    currentTasks.appendChild(singleTask);
  } else if (task.status == "done") {
    doneTasks.appendChild(singleTask);
  }
}

async function getUserSubTasks(taskId) {
  const reqSubTasks = new FormData();
  reqSubTasks.append("action", "getSubTasks");
  reqSubTasks.append("taskId", taskId);

  const requestOptions = {
    method: "POST",
    body: reqSubTasks,
  };

  let userSubTasks = await fetch("../../back/Controller/taskController.php", requestOptions);
  userSubTasks = await userSubTasks.json();

  if (userSubTasks.success == true) {
    document.querySelector("#showTaskSubClassDiv").innerHTML = "";
    let subTasksHeader = document.createElement("h4");
    subTasksHeader.innerHTML = "Sous-tâches :";
    document.querySelector("#showTaskSubClassDiv").appendChild(subTasksHeader);
    for (let subTask of userSubTasks.subTasks) {
      displaySubTask(subTask);
    }
    let addSubTaskForm = document.createElement("form");
    addSubTaskForm.setAttribute("id", "addSubTaskForm");
    addSubTaskForm.setAttribute("method", "POST");
    addSubTaskForm.setAttribute("action", "");
    let subClassDescription = document.createElement("input");
    subClassDescription.setAttribute("type", "text");
    subClassDescription.setAttribute("class", "subClassDescription");
    subClassDescription.setAttribute("placeholder", "sous-tâche");
    subClassDescription.setAttribute("name", "subClassDescription");
    addSubTaskForm.appendChild(subClassDescription);
    let AddSubClassBtn = document.createElement("button");
    AddSubClassBtn.setAttribute("id", "AddSubClassBtn");
    AddSubClassBtn.setAttribute("class", "mainButtons");
    AddSubClassBtn.innerHTML = "Ajouter";
    addSubTaskForm.appendChild(AddSubClassBtn);
    AddSubClassBtn.addEventListener("click", addSubTask);
    document.querySelector("#showTaskSubClassDiv").appendChild(addSubTaskForm);
  }
}

function displayAddTaskDiv() {
  document.querySelector("#addTaskDiv").style.display = "flex";
  document.querySelector("#addTaskDiv").style.zIndex = "1";
  document.querySelector("#toDoListDiv").style.opacity = "0.1";
  document.querySelector("#toDoListDiv").style.zIndex = "-1";
}

function closeAddTaskDiv() {
  document.querySelector("#addTaskDiv").style.display = "none";
  document.querySelector("#addTaskDiv").style.zIndex = "-1";
  document.querySelector("#toDoListDiv").style.opacity = "1";
  document.querySelector("#toDoListDiv").style.zIndex = "1";
}

async function displayTaskDetails(task) {
  taskId = task.id;
  document.querySelector("#showTaskDiv").style.display = "flex";
  document.querySelector("#showTaskDiv").style.zIndex = "1";
  document.querySelector("#toDoListDiv").style.opacity = "0.1";
  document.querySelector("#toDoListDiv").style.zIndex = "-1";
  document.querySelector("#showTaskTitle").innerHTML = `${task.title}`;
  displayTaskDescription(task);
  getUserSubTasks(task.id);
}

async function displayTaskDescription(task) {
  console.log(typeof(task.description), task);
  document.querySelector("#showTaskDescriptionDiv").innerHTML = "";
  let taskHeader = document.createElement("h4");
  taskHeader.setAttribute("id", "taskHeader");
  taskHeader.innerHTML = "Description :";
  document.querySelector("#showTaskDescriptionDiv").appendChild(taskHeader);

  if(task.description == "\r\n"){
    let newDesc = document.createElement("textarea");
    newDesc.style.width = "80%";
    newDesc.setAttribute("id", "newDesc");
    newDesc.setAttribute("name", "newDesc");
    // newDesc.setAttribute("rows", "4");
    document.querySelector("#showTaskDescriptionDiv").appendChild(newDesc);
    let saveNewDescBtn = document.createElement("button");
    saveNewDescBtn.setAttribute("id", "saveNewDescBtn");
    saveNewDescBtn.setAttribute("class", "mainButtons")
    saveNewDescBtn.innerHTML = "Ajouter";
    saveNewDescBtn.addEventListener("click", () => {
      updateTaskDescription(task, newDesc.value);
    });
    let cancelNewDescBtn = document.createElement("button");
    cancelNewDescBtn.setAttribute("id", "cancelNewDescBtn");
    cancelNewDescBtn.setAttribute("class", "mainButtons")
    cancelNewDescBtn.innerHTML = "Annuler";
    cancelNewDescBtn.addEventListener("click", () => {
      document.querySelector("#taskDescription").innerHTML = `${task.description}`;
      document.querySelector("#showTaskDescriptionDiv").removeChild(newDesc);
      document.querySelector("#showTaskDescriptionDiv").removeChild(saveNewDescBtn);
      document.querySelector("#showTaskDescriptionDiv").removeChild(cancelNewDescBtn);
    });
    document.querySelector("#showTaskDescriptionDiv").appendChild(saveNewDescBtn);
  }
  else {
    let taskDescription = document.createElement("p");
    taskDescription.setAttribute("id", "taskDescription");
    taskDescription.innerHTML = `${task.description}`;
    document.querySelector("#showTaskDescriptionDiv").appendChild(taskDescription);
    document.querySelector("#showTaskDescriptionDiv").appendChild(taskDescription);
    document.querySelector("#taskDescription").addEventListener("click", () => {
      document.querySelector("#taskDescription").innerHTML = "";
      let newDesc = document.createElement("textarea");
      newDesc.style.width = "80%";
      newDesc.setAttribute("id", "newDesc");
      newDesc.setAttribute("name", "newDesc");
      // newDesc.setAttribute("rows", "4");
      newDesc.innerHTML = `${task.description}`;
      document.querySelector("#showTaskDescriptionDiv").appendChild(newDesc);
      let saveNewDescBtn = document.createElement("button");
      saveNewDescBtn.setAttribute("id", "saveNewDescBtn");
      saveNewDescBtn.setAttribute("class", "mainButtons")
      saveNewDescBtn.innerHTML = "Modifier";
      saveNewDescBtn.addEventListener("click", () => {
        updateTaskDescription(task, newDesc.value);
      });
      let cancelNewDescBtn = document.createElement("button");
      cancelNewDescBtn.setAttribute("id", "cancelNewDescBtn");
      cancelNewDescBtn.setAttribute("class", "mainButtons")
      cancelNewDescBtn.innerHTML = "Annuler";
      cancelNewDescBtn.addEventListener("click", () => {
        document.querySelector("#taskDescription").innerHTML = `${task.description}`;
        document.querySelector("#showTaskDescriptionDiv").removeChild(newDesc);
        document.querySelector("#showTaskDescriptionDiv").removeChild(saveNewDescBtn);
        document.querySelector("#showTaskDescriptionDiv").removeChild(cancelNewDescBtn);
      });
      document.querySelector("#showTaskDescriptionDiv").appendChild(saveNewDescBtn);
    });
  }
}

function displaySubTask(subTask) {
  let singleSubTask = document.createElement("div");
  singleSubTask.setAttribute("class", "singleSubTaskDiv");
  let singleSubTaskTitle = document.createElement("h5");
  singleSubTaskTitle.innerHTML = `${subTask.description}`;
  singleSubTask.appendChild(singleSubTaskTitle);
  document.querySelector("#showTaskSubClassDiv").appendChild(singleSubTask);
  let deleteSubTaskIcon = document.createElement("i");
  deleteSubTaskIcon.setAttribute("class", "fa-regular fa-circle-xmark");
  deleteSubTaskIcon.addEventListener("click", () => {
    deleteSubTask(subTask.id);
  });
  singleSubTask.appendChild(deleteSubTaskIcon);
}

function closeTaskDetails() {
  document.querySelector("#showTaskDiv").style.display = "none";
  document.querySelector("#showTaskDiv").style.zIndex = "-1";
  document.querySelector("#toDoListDiv").style.opacity = "1";
  document.querySelector("#toDoListDiv").style.zIndex = "1";
  document.querySelector("#showTaskSubClassDiv").innerHTML = "";
  // document.querySelector("#showTaskSubClassDiv").remove;
}

async function addTask(e) {
  e.preventDefault();
  const reqAddTask = new FormData(document.querySelector("#addTaskForm"));
  reqAddTask.append("addTask", "addTask");
  const requestOptions = {
    method: "POST",
    body: reqAddTask,
  };
  let addTask = await fetch("../../back/Controller/taskController.php", requestOptions);
  addTask = await addTask.json();
  if (addTask.success == true) {
    // let task = {
    //   title: document.querySelector("#addTaskForm").taskTitle.value,
    //   description: document.querySelector("#addTaskForm").taskDescription.value,
    //   status: "to_do",
    // };
    window.location.href = "toDoList.php";
    // displayTask(task);
  }
}

async function deleteTask(taskId) {
  const reqDelete = new FormData();
  reqDelete.append("deleteTask", taskId);
  const requestOptions = {
    method: "POST",
    body: reqDelete,
  };

  let deleteTask = await fetch("../../back/Controller/taskController.php", requestOptions);
  deleteTask = await deleteTask.json();
  if (deleteTask.success == true) {
    window.location.href = "toDoList.php";
  }
}
async function deleteSubTask(subTaskId) {
  const reqDelete = new FormData();
  reqDelete.append("deleteSubTask", subTaskId);
  const requestOptions = {
    method: "POST",
    body: reqDelete,
  };

  let deleteSubTask = await fetch("../../back/Controller/taskController.php", requestOptions);
  deleteSubTask = await deleteSubTask.json();
  if (deleteSubTask.success == true) {
    getUserSubTasks(taskId);
    // window.location.href = "toDoList.php";
  }
}
async function updateTaskStatus(taskId, status) {
  const reqUpdate = new FormData();
  reqUpdate.append("updateTaskStatus", status);
  reqUpdate.append("taskId", taskId);
  const requestOptions = {
    method: "POST",
    body: reqUpdate,
  };
  let updateTaskStatus = await fetch("../../back/Controller/taskController.php", requestOptions);
  //   updateTask = await updateTask.json();
}

async function updateTaskDescription(task, newDesc) {
  const reqUpdate = new FormData();
  reqUpdate.append("updateTaskDescription", newDesc);
  reqUpdate.append("taskId", task.id);
  const requestOptions = {
    method: "POST",
    body: reqUpdate,
  };
  let updateTaskDescription = await fetch("../../back/Controller/taskController.php", requestOptions);
    updateTaskDescription = await updateTaskDescription.json();
    if (updateTaskDescription.success == true) {
      task.description = newDesc;
      displayTaskDescription(task)
      // window.location.href = "toDoList.php";
    }
}

async function addSubTask(e) {
  e.preventDefault();
  const reqAddSubTask = new FormData(document.querySelector("#addSubTaskForm"));
  reqAddSubTask.append("addSubTask", taskId);
  const requestOptions = {
    method: "POST",
    body: reqAddSubTask,
  };
  let addSubTask = await fetch("../../back/Controller/taskController.php", requestOptions);
  addSubTask = await addSubTask.json();
  if (addSubTask.success == true) {
    getUserSubTasks(taskId);
  }
}

getUserTasks();
