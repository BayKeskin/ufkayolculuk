# 🛡️ PROJECT AGENT INSTRUCTIONS & EXECUTION DOCTRINE (AGENTS.md)

## 0. CORE DOCTRINE: "THE USER IS NOT A QA TESTER"

> ### 🚨 RED LINE RULE:
> Before an engineer or AI agent tells the user "It's done, please check", "Try it now", or marks any task as completed:
> **The agent is STRICTLY OBLIGATED to autonomously test and verify all screens, every button, every form step, UI visual flaws, and all state transitions in the LIVE ENVIRONMENT using headless browser, curl, PHP/CLI scripts, and API tests.**

Under NO circumstances shall the user ever encounter:
1. A blank or white screen (`Blank Screen`),
2. An unresolved PHP/SQL/JS error, syntax error, warning, or crash,
3. An unresponsive, unclickable, or dead button,
4. Console JavaScript errors or network 404/500 failures,
5. Misaligned typography, poor borders, clipped elements, or responsive layout defects,
6. Ambiguous deliverables where what was done or how to test is unclear.

---

## 1. USER'S ROLE vs. AGENT'S ROLE
- **The User's Role:** The user is NOT a QA/test employee. Finding missing parts, broken buttons, or bugs is NEVER the user's responsibility. The user only reviews high-level product vision and user experience.
- **The Agent's Role:** Verifying and proving that the system functions logically, visually, and operationally with 100% perfection is **100% the Agent's responsibility**.

---

## 2. DUAL-MODE EXECUTION: DIRECT USER CHAT vs. TASKMANAGER AUTONOMOUS QUEUE

> ### 🛑 OPERATIONAL DIRECTIVE:
> 
> ### MODE A: DIRECT USER CHAT (User Prompts Manually in IDE Window)
> * When the user speaks to you directly in this chat:
> * **USER INSTRUCTION TAKES 100% SUPREMACY.** Address the user's request immediately.
> * **DO NOT SEARCH FOR REST API CALLS OR TASK CODES.** Do not attempt to submit to TaskManager API unless a task code was explicitly given. Simply complete the work, test autonomously, and reply directly to the user.
> 
> ### MODE B: TASKMANAGER AUTONOMOUS DISPATCH (Prompt Contains Task Code)
> * When triggered by TaskManager background queue with an assigned `task_code`:
> * Focus EXCLUSIVELY on that single task. Never jump to older tasks.
> * When complete and autonomously verified, execute the official REST API submit command provided in the dispatch prompt, then **END YOUR TURN**. Do not search TaskManager internal files or database.

---

## 3. PROJECT-NATIVE LANGUAGE & ARCHITECTURE RESPECT
1. **Respect Native Framework:** Adhere strictly to CodeIgniter 4 MVC standards (`app/Controllers`, `app/Models`, `app/Views`, `app/Services`).
2. **Project-Native Language:** This project is developed natively in Turkish. Follow Turkish UI conventions; do NOT force multi-language dictionaries unless explicitly requested by the task.
3. **Preserve Codebase Integrity:** Preserve existing code conventions, folder structures, and comments.

---

## 4. DEFINITION OF DONE (DELIVERY PROTOCOL)
Every completed task must provide an exhaustive summary formatted as follows:
1. **What Was Done (Neler Yapıldı):** Added/modified files, methods, DB schema changes.
2. **Where to Test (Nereden Test Edilir):** Direct testable local or live URLs (`http://localufkayolculuk.com/...` or `https://team.tkmdev.com/ufkayolculuk-demo/...`).
3. **How to Test (Nasıl Test Edilir):** Step-by-step credentials, actions, buttons to click, and expected outcomes.
4. **Autonomous Test Evidence (Otonom Test Kanıtı):** Summary of automated headless browser, curl, or CLI test results.

<!-- PROJECT_RULES_START -->
## 7. PROJECT-SPECIFIC AGENT RULES (PROJEYE ÖZEL KURALLAR)

> ### 📌 MANDATORY PROJECT-SPECIFIC CONSTRAINTS:
> The following project-specific technical rules, styling constraints, and workflow directives must be strictly observed for project [TKMDEV-01] Ufka Yolculuk-tkmdev:

Journey to the Horizon Web Platform Guidelines
- **Technology Stack:** CodeIgniter 4 (v4.7.4), PHP 8.2+, MySQL, Bootstrap 5.3, and Vanilla ES6+ JavaScript.
- **Local Development URL:** `http://localufkayolculuk.com/` (WampServer VirtualHost).
- **Live site demo URL:** `https://team.tkmdev.com/ufkayolculuk-demo/` 
- **Git Synchronization:** You must run `git pull` to fetch remote changes before starting a task and `git push` with a descriptive commit upon task completion.
- **REST API Synchronization:** https://ufkayolculuk.com/rest
username: uy_Rest-Worker
password: UfkA_Yol-1448
- **QA Policy:** You are not a user tester; every page and form step must be autonomously tested in the live environment.

- **DYNAMIC CODEIGNITER 4 ARCHITECTURE (STATIC HTML IS PROHIBITED):**
  - The `.html` files in the root directory are static front-end prototypes from the project’s initial design phase.
  - Under no circumstances should “on-the-fly processing” be performed on static `.html` files!
  - All pages, UI components, and data flows must operate dynamically under the CodeIgniter 4 MVC framework (`app/Controllers`, `app/Models`, `app/Services`, `app/Views`) with integration of the live API (`KitapApiService`).
  - Since data from the API is subject to change, all view templates (`app/Views/*.php`) must handle dynamic variables and data models.
  - The root `.htaccess` file redirects all page requests—including those with `.html` extensions—directly to the CodeIgniter front controller (`public/index.php`); static HTML cannot be bypassed under any circumstances.
<!-- PROJECT_RULES_END -->
