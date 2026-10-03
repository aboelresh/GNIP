\# ADR 003: Jaccard Similarity for Story Clustering



\## Status



Accepted



\## Context



The platform needs to group articles from different sources that cover the same event into a single story. An article about a political summit published by BBC, Al Jazeera, and Le Monde should cluster into one story, not three separate entries.



\## Decision



Use Jaccard similarity on article keywords to determine whether two articles cover the same event. Articles with a similarity score above 0.3 are clustered together.



\## Reasons



Jaccard similarity measures the overlap between two sets. For news articles, the set of significant keywords (entities, locations, named subjects) is a reliable signal for topical similarity. Two articles covering the same event will share a high proportion of their keywords even when written in different styles or languages.



The alternatives considered were:



TF-IDF cosine similarity: More accurate for long documents, but requires storing and computing term frequency vectors across the entire corpus. For news articles that average 300-500 words, Jaccard on extracted keywords is sufficient and significantly cheaper to compute.



Embedding-based similarity: The most accurate approach, using sentence transformers or similar models to compute semantic similarity. Ruled out because it requires a GPU or expensive API calls for every pair of articles, which does not fit the local-first, cost-minimal design of this platform.



ML clustering (DBSCAN, K-means): Requires a defined feature space and periodic full re-clustering of the corpus. Jaccard allows incremental clustering: new articles are compared only against recent stories, not the entire database.



The threshold of 0.3 was chosen empirically. Below 0.3, unrelated articles with shared common words (country names, common political terms) produce false positives. Above 0.4, genuinely related articles with different keyword extraction results fail to cluster.



\## Consequences



Clustering quality depends on keyword extraction quality. Poor AI extraction produces poor clusters. The `evidence\_level` field on stories provides a signal for cluster confidence: stories with more independent sources at higher agreement are ranked higher.



The threshold is configurable via `CLUSTERING\_THRESHOLD` in the environment, allowing operators to tune it for their content domain without code changes.

