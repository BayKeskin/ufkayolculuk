<!-- PROJECT_RULES_START -->
## 7. PROJECT-SPECIFIC AGENT RULES (PROJEYE ÖZEL KURALLAR)

> ### 📌 MANDATORY PROJECT-SPECIFIC CONSTRAINTS:
> The following project-specific technical rules, styling constraints, and workflow directives must be strictly observed for project [TKMDEV-02] Ufka Yolculuk Kitap Okuma ve Sınav:

Journey to the Horizon Web Platform Guidelines
- **Technology Stack:** CodeIgniter 4 (v4.7.4), PHP 8.2+, MySQL, Bootstrap 5.3, and Vanilla ES6+ JavaScript.
- **Local Development URL:** `http://localufkayolculuk.com/` (WampServer VirtualHost).
- **Live site demo URL** `hhttps://team.tkmdev.com/ufkayolculuk-demo/` 
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
