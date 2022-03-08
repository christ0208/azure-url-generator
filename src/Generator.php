<?php

namespace Xtrics\AzureUrlGenerator;

class Generator
{
    /**
     * Pattern of variable in beginning of specific endpoint's references.
     * 
     * @var string
     */
    private static $beginVariablePatternStr = '__';

    /**
     * Pattern of variable in the end of specific endpoint's references.
     * 
     * @var string
     */
    private static $endVariablePatternStr = '__';

    /**
     * Configuration path that contains base URL to Azure API.
     * 
     * @var string
     */
    private static $configBaseUrlPath = 'azure_basic.base_url';

    /**
     * Configuration path that contains endpoints.
     * 
     * @var string
     */
    private static $configEndpointsPath = 'azure_basic.endpoints';

    /**
     * Checks whether the reference string starts with following pattern.
     * 
     * @param string $str
     * @param string $seek
     * @return bool
     */
    private static function strStartsWith(string $str, string $seek): bool
    {
        return strpos($str, $seek, 0) === 0;
    }

    /**
     * Checks whether the reference string ends with following pattern.
     * 
     * @param string $str
     * @param string $seek
     * @return bool
     */
    private static function strEndsWith(string $str, string $seek): bool
    {
        $strLength = strlen($str);
        $seekLength = strlen($seek);
        $offsetIfTrue = $strLength - $seekLength;

        return strpos($str, $seek, $offsetIfTrue) === $offsetIfTrue;
    }

    /**
     * Checks whether the reference string starts with and ends with following pattern.
     * 
     * @param string $str
     * @return bool
     */
    private static function checkIsVariablePattern(string $str): bool
    {
        return self::strStartsWith($str, self::$beginVariablePatternStr) && self::strEndsWith($str, self::$endVariablePatternStr);
    }

    /**
     * Get base URL from Azure configuration file in Laravel project.
     *
     * @return string
     */
    private static function getBaseUrlPath(): string
    {
        return config(self::$configBaseUrlPath, '');
    }

    /**
     * Get endpoint template from Azure configuration file in Laravel project.
     * 
     * @param string $endpointName
     * @return string
     */
    private static function getEndpointTemplate(string $endpointName): string
    {
        return config(self::$configEndpointsPath . ".$endpointName", '');
    }

    /**
     * Get endpoint variable name from reference string.
     * 
     * @param string $str
     * @return string
     */
    private static function getEndpointVariableName(string $str): string
    {
        $str = str_replace(self::$beginVariablePatternStr, '', $str);
        $str = str_replace(self::$endVariablePatternStr, '', $str);

        return $str;
    }

    /**
     * Replace endpoint variables from given references to specified string in replacements array.
     * Used for replace endpoint variables in endpoint path.
     * 
     * @param array $references
     * @param array $replacements
     * @return string
     */
    private static function replaceEndpointPathVariables(array $references, array $replacements): string
    {
        $references = array_map(function ($reference) use ($replacements) {
            if (!self::checkIsVariablePattern($reference)) return $reference;

            $indexName = self::getEndpointVariableName($reference);

            if (empty($replacements[$indexName])) return $reference;

            return $replacements[$indexName];
        }, $references);

        return implode('/', $references);
    }

    /**
     * Replace endpoint variables from given references to specified string in replacements array.
     * Used for replace endpoint request data in endpoint path.
     * 
     * @param array $references
     * @param array $replacements
     * @return string
     */
    private static function replaceEndpointDataVariables(array $references, array $replacements): string
    {
        $references = array_map(function ($reference) use ($replacements) {
            $parts = explode('=', $reference);

            if (!self::checkIsVariablePattern($parts[1])) return $reference;

            $indexName = self::getEndpointVariableName($parts[1]);

            if (empty($replacements[$indexName])) return $reference;

            return $parts[0] . '=' . $replacements[$indexName];
        }, $references);

        return implode('&', $references);
    }

    /**
     * Replace endpoint variables in endpoint template to specified string in replacements array.
     * 
     * @param string $endpoint
     * @param array $replacements
     * @return string
     */
    private static function replaceEndpointVariables(string $endpoint, array $replacements): string
    {
        $endpointParts = explode('?', $endpoint, 2);
        $endpointPathReferences = explode('/', $endpointParts[0]);
        $finalEndpointPath = self::replaceEndpointPathVariables($endpointPathReferences, $replacements);

        if (count($endpointParts) == 2)
        {
            $endpointDataReferences = explode('&', $endpointParts[1]);
            $finalEndpointData = self::replaceEndpointDataVariables($endpointDataReferences, $replacements);

            return $finalEndpointPath . '?' . $finalEndpointData;
        }

        return $finalEndpointPath;
    }

    /**
     * Generate new endpoint path for specific endpoint name. Endpoint name based on specified
     * endpoints in Azure configuration file.
     * 
     * @param string $endpointName
     * @param array $replacements
     * @return string
     */
    public static function generateEndpointPath(string $endpointName, array $replacements=[]): string
    {
        return self::replaceEndpointVariables(
            self::getEndpointTemplate($endpointName),
            $replacements
        );
    }

    /**
     * Generate new URL for specific endpoint name. Endpoint name based on specified endpoints
     * in Azure configuration file.
     * 
     * @param string $endpointName
     * @param array $replacements
     * @return string
     */
    public static function generateUrl(string $endpointName, array $replacements=[]): string
    {
        return self::getBaseUrlPath() . self::generateEndpointPath($endpointName, $replacements);
    }
}