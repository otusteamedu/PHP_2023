## Attention

The configuration file for the web-server (Nginx) should include the following specific:

- the project root file is located in the `<project-path>/public` folder.

## Task specification

- To add details to a Track description the **_Decorator pattern_** should be used ('`Playback time: MM:SS`', '`Share: [social-network-links]`')
- To unify the process of providing of additional information for both Tracks and Playlists the **_Composite pattern_** should be used (for example, a Playlist could also have '`Playback time: MM:SS`', total of all Tracks in the Playlist)
- To organize paginated load of Tracks the **_Iterator pattern_** should be used
- To create Playlist object the **_Builder pattern_** should be used (add Tracks to the Builder, then get a Playlist)


## API Specification

- Endpoint for the new Track creation:
    - **POST /create-track**
    - Input (JSON):
    
        `{`
        
             title <string>
             author <string>
             genre <string>
             duration <integer>
             description <string>
        `}`
    - Response:
    
        `Status 200 OK`
        
        or (JSON)

        `Status 422 Unprocessable Content`
        
        `{`
        
             success <boolean>
             errors <array>
         `}`

- Endpoint to get the list of Tracks with an optional filter by a genre:
    - **GET /tracks?genre=genre_name**
    
    - Response (JSON):
    
        `[{`
        
            id <integer>
            title <string>
            author <string>
            genre <string>
            duration <integer>
            description <string>
            created_at <datetime>
            updated_at <datetime>
        `}]`

- Endpoint for the new Playlist creation:
    - **POST /create-list**
    - Input (JSON):
    
        `{`
        
             name <string>
             tracks-list <array>
                 title <string>
                 author <string>
                 genre <string>
                 duration <integer>
                 description <string>
        `}`
        
        or
        
        `{`
                
             name <string>
             tracks-list <array>
                 <list of existing track ids>
        `}`
    - Response:
    
        `Status 200 OK`
        
        or (JSON)

        `Status 422 Unprocessable Content`
        
        `{`
        
             success <boolean>
             errors <array>
         `}`

- Endpoint to get the list of Playlists with its Tracks:
    - **GET /lists**
    
    - Response (JSON):
    
        `[{`
        
            id <integer>
            name <string>
            created_at <datetime>
            updated_at <datetime>
            duration <string>
            tracks <array>
                id <integer>
                title <string>
                author <string>
                genre <string>
                duration <integer>
                description <string>
                created_at <datetime>
                updated_at <datetime>
        `}]`
