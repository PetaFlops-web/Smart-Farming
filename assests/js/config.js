import Groq from "groq-sdk";
import dotenv from "dotenv";

// Memuat API Key dari file .env
dotenv.config();

const groq = new Groq({ apiKey: process.env.GROQ_API_KEY });

async function main() {
    try {
        const chatCompletion = await groq.chat.completions.create({
            model: "llama-3.1-8b-instant",
            messages: [
                { role: "system", content: "Kamu adalah asisten AI yang cerdas." },
                { role: "user", content: "Jelaskan apa itu REST API dalam satu kalimat singkat." }
            ],
            temperature: 0.7,
            max_tokens: 1024,
        });

        console.log("Respon AI:");
        console.log(chatCompletion.choices[0]?.message?.content);
    } catch (error) {
        console.error("Terjadi kesalahan:", error);
    }
}

main();