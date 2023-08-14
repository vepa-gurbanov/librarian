import React from 'react';
import algoliasearch from './algoliasearch-lite.umd.js';
import {
    InstantSearch,
    SearchBox,
    Hits,
    Highlight,
} from './ReactInstantSearch.min.js';


const searchClient = algoliasearch('JRQ2JWB5KA', 'ea1c181a4aec3ab1b313e3dcad31b349');

function Hit({ hit }) {
    return (
        <article>
            {/*<img src={hit.image} alt={hit.name} />*/}
            <p>{hit.books[0]}</p>
            <h1>
                <Highlight attribute="name" hit={hit} />
            </h1>
            <p>${hit.name}</p>
        </article>
    );
}

function App() {
    return (
        <InstantSearch searchClient={searchClient} indexName="q">
            <SearchBox />
            <Hits hitComponent={Hit} />
        </InstantSearch>
    );
}
App()
