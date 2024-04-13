<!-- index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PubMed Search</title>
</head>
<body>
    <h1>PubMed Search</h1>

    <form action="/" method="get">
        <label for="keywords">Keywords:</label>
        <input type="text" name="keywords" id="keywords" value="{{ $keywords }}">

        <button type="submit">Search</button>
    </form>

    @if($paginatedArticles->isEmpty())
        <p>No articles found.</p>
    @else
        <ul>
            @foreach ($paginatedArticles as $article)
                <li>
                    <h2>{{ $article['title'] }}</h2>
                    <p>Authors: {{ $article['authors'] }}</p>
                    <p>PMID: {{ $article['pmid'] }}</p>
                    <p>Journal Citation: {{ $article['journalCitation'] }}</p>
                    <p>Snippet: {{ $article['snippet'] }}</p>
                </li>
            @endforeach
        </ul>

        {{ $paginatedArticles->links() }} <!-- Pagination links -->
    @endif
</body>
</html>
