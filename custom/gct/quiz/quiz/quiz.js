const queryString = window.location.search; 
const urlParams = new URLSearchParams(queryString); 
const quizId = urlParams.get('id'); 

function check_cookie_name(name) { 
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)')); 
    if (match) { 
        return match[2]; 
    } else { 
        console.log('--something went wrong---'); 
    } 
} 

const backlink = check_cookie_name('damares-orig-rel'); 

var quiz = { 

    // (A) PROPERTIES 
    // (A1) HTML ELEMENTS 
    hQn: null, // question <div> 
    hAns: null, // answer <div> 

    // (A2) QUIZ FLAGS 
    all: 0, // total number of questions 
    now: 0, // current question 
    ans: 0, // current correct answer 
    score: 0, // current score 
    begin: 0, // begin time 

    // (B) INIT QUIZ 
    init: () => { 
        quiz.hQn = document.getElementById("quizQn"); 
        quiz.hAns = document.getElementById("quizAns"); 

        sessionStorage.clear(); 
        quiz.load(); 
    }, 

    // (C) LOAD NEXT QUESTION/ANSWER 
    load: () => { 
        console.log('Loading next question at', Date.now()); // Log the load time

        // (C1) FORM DATA 
        let data = new FormData(); 
        data.append("qn", quiz.now); 

        // (C2) AJAX FETCH 
        fetch("ajax.php", { method: "POST", body: data, signal: AbortSignal.timeout(10000) }) 
        .then(res => res.json()).then(qna => { 
            console.log('Question received at', Date.now()); // Log the question received time

            // (C2-1) TOTAL NUMBER OF QUESTIONS 
            if (quiz.now == 0) { 
                quiz.all = qna.all; 
            } 

            // (C2-2) SET THE QUESTION 
            quiz.hQn.innerHTML = qna.q; 

            // (C2-3) SET THE OPTIONS 
            quiz.ans = qna.a; 
            quiz.hAns.innerHTML = ""; 
            qna.o.forEach((val, idx) => { 
                let o = document.createElement("div"); 
                o.className = "option"; 
                o.id = "opt" + idx; 
                o.innerHTML = val; 
                o.onclick = () => quiz.pick(idx); 
                quiz.hAns.appendChild(o); 
            }); 
            quiz.begin = Math.floor(Date.now() / 1000); 
            console.log('Begin time set at', quiz.begin); // Log the begin time
        }); 
    }, 

    // (D) PICK AN OPTION 
    pick: idx => { 
        console.log('Option picked at', Date.now()); // Log the option picked time

        // (D1) DETACH ALL ONCLICK & SET RIGHT/WRONG CSS 
        for (let o of quiz.hAns.getElementsByClassName("option")) { 
            o.onclick = ""; 
        } 
        let answer; 
        let o = document.getElementById("opt" + idx); 
        if (idx == quiz.ans) { 
            answer = 1; 
            quiz.score++; 
            o.classList.add("correct"); 
        } else { 
            answer = 0; 
            o.classList.add("wrong"); 
        } 

        quiz.now++; 
        // time fine quiz 
        let end = Math.floor(Date.now() / 1000); 
        console.log('End time set at', end); // Log the end time
        let question = quiz.now; 
        console.log("quiz now ",quiz.now)

        let userArray; 

        if (answer == 1) { 
            userArray = {
                id: quiz.now,
                begin_time: quiz.begin,
                end_time: end,
                pick: idx
            }; 
        } else { 
            userArray = {
                id: quiz.now,
                begin_time: quiz.begin,
                end_time: 0,
                pick: idx
            }; 
        } 

        sessionStorage.setItem(question, JSON.stringify(userArray)); 

        // (D3) NEXT QUESTION OR END GAME 
        setTimeout(() => { 
            if (quiz.now < quiz.all) { 
                quiz.load(); 
            } else { 
                let domanda; 
                if (quiz.score == 1) { 
                    domanda = 'domanda'; 
                } else { 
                    domanda = 'domande'; 
                } 

                quiz.hQn.innerHTML = `Hai risposto correttamente a ${quiz.score} ${domanda} su ${quiz.all}.<br><a href="../relation-details.php?id=${backlink}&quiz=ok">Torna indietro</a>`; 
                quiz.hAns.innerHTML = ""; 

                var obj = Object.keys(sessionStorage).reduce(function(obj, key) { 
                    obj[key] = sessionStorage.getItem(key); 
                    return obj; 
                }, {}); 

                console.log(obj); 

                $.post("script.php", { total: obj }); 
            } 
        }, 1000); 
    }, 

    // (E) RESET QUIZ 
    reset: () => { 
        quiz.all = 0; 
        quiz.now = 0; 
        quiz.ans = 0; 
        quiz.score = 0; 
        quiz.draw(); 
    } 
}; 

window.addEventListener("DOMContentLoaded", quiz.init);
