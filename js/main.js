// portrait czy landscape? ----------------------------
//document.body.clientWidth
//document.body.clientHeight

const FORCE_RANDOM_ORDER_COUNT = 3;
const QUIT_QUIZ_COUNT = 2;
let imageNumber = 0;
let imageLeft = 0;
let imageCurr = 0;

let quizList = [];
let randOrder = false;
let notTouched = 0;

const showStatus = () => {
  document.getElementById("status").textContent =
    "Images left = " + imageLeft + " / " + imageNumber;
};

const showItem = (itemNo) => {
  //? może tutaj też pobierać rozmiary "okna" i odpowiednio ustawiać wymiary obrazka (poprzez style w %) ???

  // let item = document.createElement("img");
  // item.src = quizList[itemNo]["img"];
  // item.className = "quizImg";
  // item.alt = "";
  // let oldItem = document.getElementByClassName("quizImg");
  // oldItem.remove();
  // document.getElementById("quiz__content").appendChild(item);

  document.getElementById(
    "quiz__content"
  ).innerHTML = `<img class="quizImg" src="${quizList[itemNo]["img"]}" alt="(${itemNo})">`;
};

const showItemB = (itemNo) => {
  // wersja z automatycznym skalowaniem obrazka przez style background-image
  document.getElementById("quiz__content").style.backgroundImage = quizList[itemNo]["img"];
};

const getNextQuestionPos = (lastPos, randNext = true) => {
  // funkcja zwraca pozycję w tablicy quizList następnego pytania
  // lastPos zawiera pozycję poprzedniego pytania
  // randNext określa czy kolejne pytanie ma być wg listy czy losowo
  let newPos = lastPos;
  if (randNext) {
    newPos = Math.floor(Math.random() * imageNumber);
  }
  do {
    newPos++;
    if (newPos >= imageNumber) {
      newPos = 0;
    }
    if (quizList[newPos]["done"] == false) {
      if (imageLeft > 1 && newPos == lastPos) {
        continue; // zabezpieczenie na wybranie tego samego obrazka gdy jest więcej
      }
      return newPos;
    }
  } while (true); // musi wyjść z pętli i funkcji odnajdując odpowiednie pytanie z done==false
};

const quizFinished = () => {
  //koniec testu

  //pokaż wyniki...
  showStatus();
  document.getElementById("quiz__content").innerHTML = `<h1>Koniec quizu - gratulacje!</h1>`;

  let myobj = document.getElementById("quiz__control");
  myobj.remove();

  //posprzątaj pamięć
  quizList.splice(0, imageNumber);
  //imageNumber = 0;
  //imageLeft = 0;

  //potem odśwież stronę
  setTimeout("location.href='http://127.0.0.1:5500';", 10000); //! link wstawiony na sztywno !!!
};

const answer = (correct = 0) => {
  quizList[imageCurr]["count"]++; // ile razy było już to pytanie
  let finished = false;
  // sprawdzenie czy nie koniec quizu
  if (imageLeft <= 0) {
    finished = true;
  } else {
    let notTouched = 0;
    for (i = 0; i < imageNumber; i++) {
      if (quizList[i]["count"] == 0) {
        notTouched++;
      }
    }
    console.log("notTouched = ", notTouched);
    if (notTouched <= 0 && imageLeft <= QUIT_QUIZ_COUNT) {
      finished = true;
    }
  }
  if (finished === true) {
    quizFinished();
    return;
  } else {
    // wymuszenie losowej kolejności dla ostatnich obrazków
    if (imageLeft <= FORCE_RANDOM_ORDER_COUNT) {
      randOrder = true;
      //showOptions();
    }
  }
  if (correct == 1) {
    quizList[imageCurr]["done"] = true;
    imageLeft--;
  }
  showStatus();
  imageCurr = getNextQuestionPos(imageCurr, randOrder);
  showItem(imageCurr);
  console.log("aktualna pozycja = ", imageCurr);
  console.log("losowa kolejność = ", randOrder);
  //console.log(quizList);
};

const startQuiz = (e) => {
  e.preventDefault();
  e.stopPropagation();

  imageNumber = quizList.length;
  if (imageNumber <= QUIT_QUIZ_COUNT) {
    document.getElementById("status").textContent =
      "Add more images for quiz! (Must be more than " + QUIT_QUIZ_COUNT + ")";
    return;
  }

  //createQuizHTML();
  let myobj = document.getElementById("setup");
  myobj.remove();
  myobj = document.getElementById("app");

  let quizDiv = document.createElement("div");
  quizDiv.id = "quiz";
  quizDiv.innerHTML = `<div id="quiz__content" class="quiz__content">
      <h1 id='temp'>Przygotowanie quizu...</h1>
    </div>
    <div id="quiz__control" class="quiz__control">
      <button id="live-button__yes" onclick="answer(1)" type="button" class="live-button">
        <span>GOOD</span>
      </button>
      <button id="live-button__no" onclick="answer(0)" type="button" class="live-button">
        <span>BAD</span>
      </button>
    </div>`;
  myobj.appendChild(quizDiv);

  // ustal następne pytanie
  if (randOrder) {
    imageCurr = getNextQuestionPos(0, true);
  } else {
    imageCurr = 0;
  }
  document.getElementById("temp").remove();
  showItem(imageCurr);
};

const runQuiz = document.getElementById("runquiz--form");
runQuiz.addEventListener("submit", startQuiz);

// ************************ Drag and drop ***************** //
let dropArea = document.getElementById("drop-area");

// Prevent default drag behaviors
["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
  dropArea.addEventListener(eventName, preventDefaults, false);
  document.body.addEventListener(eventName, preventDefaults, false);
});

// Highlight drop area when item is dragged over it
["dragenter", "dragover"].forEach((eventName) => {
  dropArea.addEventListener(eventName, highlight, false);
});
["dragleave", "drop"].forEach((eventName) => {
  dropArea.addEventListener(eventName, unhighlight, false);
});

// Handle dropped files
dropArea.addEventListener("drop", handleDrop, false);

function preventDefaults(e) {
  e.preventDefault();
  e.stopPropagation();
}

function highlight(e) {
  dropArea.classList.add("highlight");
}

function unhighlight(e) {
  dropArea.classList.remove("active");
}

function handleDrop(e) {
  var dt = e.dataTransfer;
  var files = dt.files;

  handleFiles(files);
}

function handleFiles(files) {
  files = [...files];
  files.forEach(previewFile);
  document.getElementById("status").textContent = "Liczba obrazków = " + imageNumber;
}

function previewFile(file) {
  let reader = new FileReader();
  reader.readAsDataURL(file);
  reader.onloadend = function () {
    let img = document.createElement("img");
    img.src = reader.result;
    document.getElementById("gallery").appendChild(img);
    quizList.push({ "done": false, "count": 0, "img": reader.result });
    imageNumber += 1;
    imageLeft = imageNumber;
    showStatus();
  };
}
