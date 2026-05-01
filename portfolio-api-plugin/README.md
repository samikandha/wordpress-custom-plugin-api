# Portfolio API Plugin

![WordPress](https://img.shields.io/badge/WordPress-5.8+-blue.svg)
![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4.svg)
![License](https://img.shields.io/badge/license-GPLv2-green.svg)

A professional, robust WordPress plugin designed to seamlessly manage portfolio entries and expose them via a standardized, secure REST API endpoint. 

Built with clean architecture, object-oriented programming (OOP), and production-ready best practices. This plugin serves as a headless WordPress enabler for modern frontend frameworks (React, Vue, Next.js).

## 🚀 Features

*   **Custom Post Type Architecture:** Registers a scalable `portfolio` Custom Post Type with full Gutenberg support.
*   **Headless-Ready REST API:** Exposes a clean, optimized custom endpoint at `/wp-json/portfolio/v1/items`.
*   **Standardized JSON Responses:** Enforces a strict response contract (Status, Message, Data payload).
*   **Built-in Pagination:** Supports seamless data fetching utilizing `page` and `per_page` query parameters, with total counts provided in response headers.
*   **Solid Error Handling:** Graceful try-catch exception handling and 404/500 HTTP status code responses.
*   **Security & Validation:** Param validation, sanitization, and permission callback stubbing baked in.
*   **Object-Oriented Design:** Organized using single-responsibility principles and strict typing constraints where possible.

## 🛠 Tech Stack

*   **WordPress Core API** (Plugin, Hooks, CPT API, REST API)
*   **PHP 7.4+** (OOP patterns, try-catch, encapsulation)

## 📁 Project Structure

```text
portfolio-api-plugin/
├── portfolio-api-plugin.php      # Entry point & Bootstrap
├── includes/
│   ├── class-post-type.php       # Portfolio CPT Registration logic
│   └── class-api.php             # Custom REST API routing and controllers
├── assets/
│   ├── admin.png                 # Admin dashboard preview 
│   └── api.png                   # Postman API response preview
└── README.md                     # Documentation
```

## ⚙️ Installation

1.  Clone or download this repository.
2.  Upload the `portfolio-api-plugin` directory to your `/wp-content/plugins/` directory.
3.  Navigate to the **Plugins** screen in your WordPress admin area.
4.  Activate the **Portfolio API Plugin**.
5.  Go to **Settings > Permalinks** and simply click "Save Changes" to flush the rewrite rules (Crucial for the new Custom Post Type to work correctly).

## 📡 API Endpoint Documentation

### Get All Portfolio Items

Retrieves a paginated list of published portfolio items.

*   **URL:** `/wp-json/portfolio/v1/items`
*   **Method:** `GET`

#### Query Parameters

| Parameter  | Type    | Default | Description                                      |
| ---------- | ------- | ------- | ------------------------------------------------ |
| `page`     | Integer | `1`     | Current page of the collection.                  |
| `per_page` | Integer | `10`    | Maximum number of items to be returned (Max 100). |

#### Success Response (200 OK)

```json
{
  "success": true,
  "message": "Portfolio items retrieved successfully.",
  "data": [
    {
      "id": 101,
      "title": "Modern React Dashboard",
      "slug": "modern-react-dashboard",
      "excerpt": "A high-performance dashboard built with React...",
      "content": "<p>Full case study content here...</p>\n",
      "thumbnail": "https://example.com/wp-content/uploads/2023/10/dashboard.jpg",
      "date": "2023-10-25T14:30:00+00:00",
      "modified": "2023-10-26T09:15:00+00:00",
      "link": "https://example.com/portfolio/modern-react-dashboard/",
      "technologies": ["React", "TypeScript", "Tailwind CSS"]
    }
  ]
}
```

#### Error Response (404 Not Found)

```json
{
  "success": false,
  "message": "No portfolio items found.",
  "data": []
}
```

## 🖼 Assets & Screenshots

*Note: Replace the placeholder images in the `/assets/` directory with real screenshots once deployed.*

*   `admin.png`: Screenshot of the Portfolio Custom Post Type in the WordPress Admin dashboard.
*   `api.png`: Screenshot of the API JSON response in Postman or a browser.

## 💼 Purpose

This project is designed to demonstrate advanced WordPress plugin development skills, highlighting clean code architecture, proper usage of the WordPress REST API, and an understanding of modern headless CMS requirements. It serves as an ideal backend service for a decoupled developer portfolio website.

---
*Developed by a Senior WordPress Developer.*
