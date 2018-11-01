@webUI @insulated @disablePreviews
Feature: Locks
  As a user
  I would like to be able to delete locks of files and folders
  So that I can access files with locks that have not been cleared

  Background:
    Given user "user1" has been created
    And user "user1" has logged in using the webUI
    And the user has browsed to the files page

  Scenario: setting a lock shows the lock symbols at the correct files/folders
    Given the user "user1" has locked the folder "simple-folder" setting following properties
      | lockscope | shared |
    When the user reloads the current page of the webUI
    Then the folder "simple-folder" should be marked as locked on the webUI
    And the folder "simple-folder" should be marked as locked by user "receiver" in the locks tab of the details panel on the webUI
    But the folder "simple-empty-folder" should not be marked as locked on the webUI

#  Scenario: unlocking by webDAV deletes the lock symbols at the correct files/folders

#  Scenario: setting a lock on a folder shows the symbols at the sub-elements
#  Scenario: setting a depth:0 lock on a folder does not shows the symbols at the sub-elements
  #-H "Depth: 0"
#  Scenario: delete the only remaining lock deletes the lock symbol
#  Scenario: delete a lock that was created by an other user results in an error
#  Scenario: delete an exclusive lock of a file
#  Scenario: delete an exclusive lock of a folder
#  Scenario: delete an exclusive lock of a folder by deleting it from a file in the folder
#  Scenario: delete the first shared lock of a file
#  Scenario: delete the second shared lock of a file
#  Scenario: delete the last shared lock of a file
#  Scenario: delete the first shared lock of a folder
#  Scenario: delete the second shared lock of a folder
#  Scenario: delete the last in shared lock of a folder
#  Scenario: lock set on a shared file shows the lock information for all involved users
#  Scenario: delete/upload/rename/move a locked file gives a nice error message
#  Scenario: unshare locked folder/file
#  Scenario: decline/accept locked folder/file