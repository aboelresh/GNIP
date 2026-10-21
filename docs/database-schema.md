\# GNIP Database Schema



\## Entity Relationship Diagram



```mermaid

erDiagram

\&#x20;   users {

\&#x20;       bigint id PK

\&#x20;       string name

\&#x20;       string email

\&#x20;       string password

\&#x20;       string role

\&#x20;       timestamp created\\\_at

\&#x20;   }



\&#x20;   categories {

\&#x20;       bigint id PK

\&#x20;       string slug

\&#x20;       json name

\&#x20;       string icon

\&#x20;       string color

\&#x20;       boolean is\\\_active

\&#x20;   }



\&#x20;   sources {

\&#x20;       bigint id PK

\&#x20;       string name

\&#x20;       string slug

\&#x20;       string feed\\\_url

\&#x20;       string feed\\\_type

\&#x20;       string country\\\_code

\&#x20;       string language

\&#x20;       string bias

\&#x20;       string type

\&#x20;       int reliability\\\_score

\&#x20;       boolean is\\\_active

\&#x20;       timestamp last\\\_fetched\\\_at

\&#x20;   }



\&#x20;   articles {

\&#x20;       bigint id PK

\&#x20;       bigint source\\\_id FK

\&#x20;       bigint category\\\_id FK

\&#x20;       string title

\&#x20;       string url

\&#x20;       text description

\&#x20;       string author

\&#x20;       string language

\&#x20;       string country\\\_code

\&#x20;       timestamp published\\\_at

\&#x20;       string status

\&#x20;       boolean is\\\_duplicate

\&#x20;       bigint duplicate\\\_of FK

\&#x20;       int importance\\\_score

\&#x20;       json ai\\\_summary

\&#x20;       json ai\\\_categories

\&#x20;   }



\&#x20;   stories {

\&#x20;       bigint id PK

\&#x20;       bigint category\\\_id FK

\&#x20;       string slug

\&#x20;       json title

\&#x20;       json summary

\&#x20;       string evidence\\\_level

\&#x20;       int evidence\\\_score

\&#x20;       int importance\\\_score

\&#x20;       int sources\\\_count

\&#x20;       int articles\\\_count

\&#x20;       boolean is\\\_trending

\&#x20;       boolean is\\\_published

\&#x20;       json languages

\&#x20;       json countries

\&#x20;       timestamp first\\\_reported\\\_at

\&#x20;       timestamp last\\\_updated\\\_at

\&#x20;   }



\&#x20;   story\\\_articles {

\&#x20;       bigint story\\\_id FK

\&#x20;       bigint article\\\_id FK

\&#x20;       float relevance\\\_score

\&#x20;       boolean is\\\_primary

\&#x20;   }



\&#x20;   briefings {

\&#x20;       bigint id PK

\&#x20;       string type

\&#x20;       json title

\&#x20;       json summary

\&#x20;       json content

\&#x20;       int stories\\\_count

\&#x20;       int articles\\\_count

\&#x20;       int sources\\\_count

\&#x20;       timestamp period\\\_start

\&#x20;       timestamp period\\\_end

\&#x20;       boolean is\\\_published

\&#x20;       timestamp published\\\_at

\&#x20;   }



\&#x20;   entities {

\&#x20;       bigint id PK

\&#x20;       string slug

\&#x20;       string type

\&#x20;       json name

\&#x20;       json aliases

\&#x20;       json metadata

\&#x20;   }



\&#x20;   claims {

\&#x20;       bigint id PK

\&#x20;       bigint story\\\_id FK

\&#x20;       json text

\&#x20;       string status

\&#x20;       int confirmed\\\_by\\\_count

\&#x20;       int disputed\\\_by\\\_count

\&#x20;   }



\&#x20;   ai\\\_logs {

\&#x20;       bigint id PK

\&#x20;       string provider

\&#x20;       string model

\&#x20;       string operation

\&#x20;       string status

\&#x20;       int total\\\_tokens

\&#x20;       float cost\\\_usd

\&#x20;       float duration\\\_seconds

\&#x20;       timestamp created\\\_at

\&#x20;   }



\&#x20;   user\\\_source\\\_preferences {

\&#x20;       bigint id PK

\&#x20;       bigint user\\\_id FK

\&#x20;       bigint source\\\_id FK

\&#x20;       boolean is\\\_enabled

\&#x20;   }



\&#x20;   users ||--o{ user\\\_source\\\_preferences : "has"

\&#x20;   sources ||--o{ user\\\_source\\\_preferences : "has"

\&#x20;   sources ||--o{ articles : "publishes"

\&#x20;   categories ||--o{ articles : "categorizes"

\&#x20;   categories ||--o{ stories : "categorizes"

\&#x20;   articles ||--o{ story\\\_articles : "belongs to"

\&#x20;   stories ||--o{ story\\\_articles : "contains"

\&#x20;   stories ||--o{ claims : "has"

```



\## Tables Summary



| Table | Description | Rows (approx) |

|-------|-------------|---------------|

| users | Platform users with role-based access | Small |

| categories | News categories (multilingual JSON) | 10 |

| sources | News sources with feed config | 27+ |

| articles | Raw ingested articles | 1000s |

| stories | Clustered story groups | 100s |

| story\_articles | M2M: stories ↔ articles | 1000s |

| briefings | AI-generated daily/weekly/monthly | Small |

| entities | Named entities extracted by AI | 100s |

| claims | Factual claims extracted from stories | 100s |

| ai\_logs | AI provider usage and cost tracking | 1000s |

| user\_source\_preferences | Per-user source on/off settings | Small |



\## Key Design Decisions



\- \*\*JSON columns\*\* for multilingual content (title, summary, name) — supports ar, en, fr, es, it

\- \*\*FULLTEXT indexes\*\* on articles.title and articles.description for Arabic search

\- \*\*Jaccard similarity\*\* for story clustering via story\_articles pivot

\- \*\*source\_id on articles\*\* (not stories) — stories aggregate multiple sources

