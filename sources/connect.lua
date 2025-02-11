local API = {}
local HttpService = game:GetService("HttpService")
local cache = {}

local function customHash(str)
    local seed = 5381
    local output = ""
    local prime = 31
    local offset = 0

    for i = 1, string.len(str) do
        local char = string.byte(str, i)
        offset = (offset + char * prime) % 255
    end

    for i = 1, string.len(str) do
        local char = string.byte(str, i)
        seed = (bit32.band((seed * prime), 0xFFFFFFFF))
        local xorResult = bit32.bxor(seed, (char * offset))
        seed = bit32.band(xorResult, 0xFFFFFFFF)
        offset = (offset + char) % 255
        output = output .. string.char((seed % 26) + 97)
    end

    return "gKnoW78niy5BDGx" .. output .. "32d6tYQPaZPATHE"
end

function API.secureRequest(url, method, body, retries)
    retries = retries or 3
    local cacheKey = method .. url .. HttpService:JSONEncode(body or {})
    
    -- Check cache
    if cache[cacheKey] and os.time() - cache[cacheKey].timestamp < 60 then
        return cache[cacheKey].data
    end

    local function tryRequest()
        local generatedString = randomString(19)
        local timestamp = os.time()
        
        local response = request({
            Url = url,
            Method = method,
            Headers = {
                ["Content-Type"] = "application/json",
                ["RILEYYS."] = customHash(generatedString .. "nZcDmPqRtUvWxYz"),
                ["RILEYYS.2"] = generatedString,
                ["Timestamp"] = timestamp,
                ["API-Version"] = "1.0",
                ["Game-Id"] = game.GameId
            },
            Body = HttpService:JSONEncode(body or {})
        })

        if response.Success then
            -- Cache successful response
            cache[cacheKey] = {
                data = response,
                timestamp = os.time()
            }
        end

        return response
    end

    -- Retry logic
    for attempt = 1, retries do
        local success, result = pcall(tryRequest)
        if success and result.Success then
            return result
        end
        wait(attempt * 2) -- Exponential backoff
    end

    warn("API Request failed after " .. retries .. " attempts")
    return nil
end

-- Example usage
function API.sendPlayerData(player, data)
    return API.secureRequest("https://your-api.com/player/data", "POST", {
        userId = player.UserId,
        data = data
    })
end

return API