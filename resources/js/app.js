import "./bootstrap.js";
import PasswordGenerator from "@/libs/password-generator.js";

new PasswordGenerator({
    generatorUri: 'generate-password',
    passwordGeneratorFormId: 'password-generator--form',
    generateElementId: 'password-generator--generate',
    outputElementId: 'password-generator--result',
})
