# Vanilo Cloud PHP SDK Changelog

## Unreleased
##### 2023-XX-YY

- Fixed the auth/token endpoint path
- Fixed `LaravelTokenStore` using unstable cache method

## 0.5.0
##### 2023-11-13

- Added the Laravel Cache Token Store driver

## 0.4.0
##### 2023-04-20

- Added accept JSON headers to all requests
- Fixed validation errors chaining into a misleading 200 response

## 0.3.0
##### 2023-04-12

- Added rawPost, rawPatch and rawDelete method to the api client
- Added create, update and delete taxonomies endpoint

## 0.2.0
##### 2023-01-31

- Fixed Taxonomy hydration in its list endpoint
- Added `RateLimitExceededException`
- Added the Apc token store (used by default if apcu is enabled and no explicit store was specified)

## 0.1.0
##### 2023-01-31

- Initial release
- Sandbox and production accounts can be used
- Wangling access/refresh tokens and credentials
- Taxonomies can be retrieved
- Raw GET responses can be retrieved
