// option
typedef struct uiInitOptions uiInitOptions;
struct uiInitOptions
{
    unsigned long long Size;
};
const char *uiInit(uiInitOptions *options);
void uiUninit(void);
void uiFreeInitError(const char *err);
void uiMain(void);
void uiMainSteps(void);
int uiMainStep(int wait);
void uiQuit(void);
void uiQueueMain(void (*f)(void *data), void *data);
void uiTimer(int milliseconds, int (*f)(void *data), void *data);
void uiOnShouldQuit(int (*f)(void *data), void *data);
void uiFreeText(char *text);

// control
typedef struct uiControl uiControl;
struct uiControl
{
    unsigned int Signature;
    unsigned int OSSignature;
    unsigned int TypeSignature;
    void (*Destroy)(uiControl *);
    unsigned long long (*Handle)(uiControl *);
    uiControl *(*Parent)(uiControl *);
    void (*SetParent)(uiControl *, uiControl *);
    int (*Toplevel)(uiControl *);
    int (*Visible)(uiControl *);
    void (*Show)(uiControl *);
    void (*Hide)(uiControl *);
    int (*Enabled)(uiControl *);
    void (*Enable)(uiControl *);
    void (*Disable)(uiControl *);
};
void uiControlDestroy(uiControl *);
unsigned long long uiControlHandle(uiControl *);
uiControl *uiControlParent(uiControl *);
void uiControlSetParent(uiControl *, uiControl *);
int uiControlToplevel(uiControl *);
int uiControlVisible(uiControl *);
void uiControlShow(uiControl *);
void uiControlHide(uiControl *);
int uiControlEnabled(uiControl *);
void uiControlEnable(uiControl *);
void uiControlDisable(uiControl *);
uiControl *uiAllocControl(unsigned long long n, unsigned int OSsig, unsigned int typesig, const char *typenamestr);
void uiFreeControl(uiControl *);
void uiControlVerifySetParent(uiControl *, uiControl *);
int uiControlEnabledToUser(uiControl *);
void uiUserBugCannotSetParentOnToplevel(const char *type);

// window
typedef struct uiWindow uiWindow;
char *uiWindowTitle(uiWindow *w);
void uiWindowSetTitle(uiWindow *w, const char *title);
void uiWindowContentSize(uiWindow *w, int *width, int *height);
void uiWindowSetContentSize(uiWindow *w, int width, int height);
int uiWindowFullscreen(uiWindow *w);
void uiWindowSetFullscreen(uiWindow *w, int fullscreen);
void uiWindowOnContentSizeChanged(uiWindow *w, void (*f)(uiWindow *, void *), void *data);
void uiWindowOnClosing(uiWindow *w, int (*f)(uiWindow *w, void *data), void *data);
int uiWindowBorderless(uiWindow *w);
void uiWindowSetBorderless(uiWindow *w, int borderless);
void uiWindowSetChild(uiWindow *w, uiControl *child);
int uiWindowMargined(uiWindow *w);
void uiWindowSetMargined(uiWindow *w, int margined);
uiWindow *uiNewWindow(const char *title, int width, int height, int hasMenubar);

const char *uiOpenFile(uiWindow *parent);
const char *uiSaveFile(uiWindow *parent);
void uiMsgBox(uiWindow *parent, const char *title, const char *description);
void uiMsgBoxError(uiWindow *parent, const char *title, const char *description);

// box
typedef struct uiBox uiBox;
void uiBoxAppend(uiBox *b, uiControl *child, int stretchy);
void uiBoxDelete(uiBox *b, int index);
int uiBoxPadded(uiBox *b);
void uiBoxSetPadded(uiBox *b, int padded);
uiBox *uiNewHorizontalBox(void);
uiBox *uiNewVerticalBox(void);

// button
typedef struct uiButton uiButton;
const char *uiButtonText(uiButton *b);
void uiButtonSetText(uiButton *b, const char *text);
void uiButtonOnClicked(uiButton *b, void (*f)(uiButton *b, void *data), void *data);
uiButton *uiNewButton(const char *text);

// Checkbox
typedef struct uiCheckbox uiCheckbox;
char *uiCheckboxText(uiCheckbox *c);
void uiCheckboxSetText(uiCheckbox *c, const char *text);
void uiCheckboxOnToggled(uiCheckbox *c, void (*f)(uiCheckbox *c, void *data), void *data);
int uiCheckboxChecked(uiCheckbox *c);
void uiCheckboxSetChecked(uiCheckbox *c, int checked);
uiCheckbox *uiNewCheckbox(const char *text);

// Entry
typedef struct uiEntry uiEntry;
const char *uiEntryText(uiEntry *e);
void uiEntrySetText(uiEntry *e, const char *text);
void uiEntryOnChanged(uiEntry *e, void (*f)(uiEntry *e, void *data), void *data);
int uiEntryReadOnly(uiEntry *e);
void uiEntrySetReadOnly(uiEntry *e, int readonly);
uiEntry *uiNewEntry(void);
uiEntry *uiNewPasswordEntry(void);
uiEntry *uiNewSearchEntry(void);

// Label
typedef struct uiLabel uiLabel;
const char *uiLabelText(uiLabel *l);
void uiLabelSetText(uiLabel *l, const char *text);
uiLabel *uiNewLabel(const char *text);

// Tab
typedef struct uiTab uiTab;
void uiTabAppend(uiTab *t, const char *name, uiControl *c);
void uiTabInsertAt(uiTab *t, const char *name, int before, uiControl *c);
void uiTabDelete(uiTab *t, int index);
int uiTabNumPages(uiTab *t);
int uiTabMargined(uiTab *t, int page);
void uiTabSetMargined(uiTab *t, int page, int margined);
uiTab *uiNewTab(void);

// Group
typedef struct uiGroup uiGroup;
const char *uiGroupTitle(uiGroup *g);
void uiGroupSetTitle(uiGroup *g, const char *title);
void uiGroupSetChild(uiGroup *g, uiControl *c);
int uiGroupMargined(uiGroup *g);
void uiGroupSetMargined(uiGroup *g, int margined);
uiGroup *uiNewGroup(const char *title);

// Spinbox
typedef struct uiSpinbox uiSpinbox;
int uiSpinboxValue(uiSpinbox *s);
void uiSpinboxSetValue(uiSpinbox *s, int value);
void uiSpinboxOnChanged(uiSpinbox *s, void (*f)(uiSpinbox *s, void *data), void *data);
uiSpinbox *uiNewSpinbox(int min, int max);

// Slider
typedef struct uiSlider uiSlider;
int uiSliderValue(uiSlider *s);
void uiSliderSetValue(uiSlider *s, int value);
void uiSliderOnChanged(uiSlider *s, void (*f)(uiSlider *s, void *data), void *data);
uiSlider *uiNewSlider(int min, int max);

// ProgressBar
typedef struct uiProgressBar uiProgressBar;
int uiProgressBarValue(uiProgressBar *p);
void uiProgressBarSetValue(uiProgressBar *p, int n);
uiProgressBar *uiNewProgressBar(void);

// Separator
typedef struct uiSeparator uiSeparator;
uiSeparator *uiNewHorizontalSeparator(void);
uiSeparator *uiNewVerticalSeparator(void);

// Combobox
typedef struct uiCombobox uiCombobox;
void uiComboboxAppend(uiCombobox *c, const char *text);
int uiComboboxSelected(uiCombobox *c);
void uiComboboxSetSelected(uiCombobox *c, int n);
void uiComboboxOnSelected(uiCombobox *c, void (*f)(uiCombobox *c, void *data), void *data);
uiCombobox *uiNewCombobox(void);

// EditableCombobox
typedef struct uiEditableCombobox uiEditableCombobox;
void uiEditableComboboxAppend(uiEditableCombobox *c, const char *text);
const char *uiEditableComboboxText(uiEditableCombobox *c);
void uiEditableComboboxSetText(uiEditableCombobox *c, const char *text);
// TODO what do we call a function that sets the currently selected item and fills the text field with it? editable comboboxes have no consistent concept of selected item
void uiEditableComboboxOnChanged(uiEditableCombobox *c, void (*f)(uiEditableCombobox *c, void *data), void *data);
uiEditableCombobox *uiNewEditableCombobox(void);

// RadioButtons
typedef struct uiRadioButtons uiRadioButtons;
void uiRadioButtonsAppend(uiRadioButtons *r, const char *text);
int uiRadioButtonsSelected(uiRadioButtons *r);
void uiRadioButtonsSetSelected(uiRadioButtons *r, int n);
void uiRadioButtonsOnSelected(uiRadioButtons *r, void (*f)(uiRadioButtons *, void *), void *data);
uiRadioButtons *uiNewRadioButtons(void);

// DateTimePicker
struct tm;
typedef struct uiDateTimePicker uiDateTimePicker;
// TODO document that tm_wday and tm_yday are undefined, and tm_isdst should be -1
// TODO document that for both sides
// TODO document time zone conversions or lack thereof
// TODO for Time: define what values are returned when a part is missing
void uiDateTimePickerTime(uiDateTimePicker *d, struct tm *time);
void uiDateTimePickerSetTime(uiDateTimePicker *d, const struct tm *time);
void uiDateTimePickerOnChanged(uiDateTimePicker *d, void (*f)(uiDateTimePicker *, void *), void *data);
uiDateTimePicker *uiNewDateTimePicker(void);
uiDateTimePicker *uiNewDatePicker(void);
uiDateTimePicker *uiNewTimePicker(void);

// MultilineEntry
// TODO provide a facility for entering tab stops?
typedef struct uiMultilineEntry uiMultilineEntry;
const char *uiMultilineEntryText(uiMultilineEntry *e);
void uiMultilineEntrySetText(uiMultilineEntry *e, const char *text);
void uiMultilineEntryAppend(uiMultilineEntry *e, const char *text);
void uiMultilineEntryOnChanged(uiMultilineEntry *e, void (*f)(uiMultilineEntry *e, void *data), void *data);
int uiMultilineEntryReadOnly(uiMultilineEntry *e);
void uiMultilineEntrySetReadOnly(uiMultilineEntry *e, int readonly);
uiMultilineEntry *uiNewMultilineEntry(void);
uiMultilineEntry *uiNewNonWrappingMultilineEntry(void);

// MenuItem
typedef struct uiMenuItem uiMenuItem;
void uiMenuItemEnable(uiMenuItem *m);
void uiMenuItemDisable(uiMenuItem *m);
void uiMenuItemOnClicked(uiMenuItem *m, void (*f)(uiMenuItem *sender, uiWindow *window, void *data), void *data);
int uiMenuItemChecked(uiMenuItem *m);
void uiMenuItemSetChecked(uiMenuItem *m, int checked);

// Menu
typedef struct uiMenu uiMenu;
uiMenuItem *uiMenuAppendItem(uiMenu *m, const char *name);
uiMenuItem *uiMenuAppendCheckItem(uiMenu *m, const char *name);
uiMenuItem *uiMenuAppendQuitItem(uiMenu *m);
uiMenuItem *uiMenuAppendPreferencesItem(uiMenu *m);
uiMenuItem *uiMenuAppendAboutItem(uiMenu *m);
void uiMenuAppendSeparator(uiMenu *m);
uiMenu *uiNewMenu(const char *name);

// Area
typedef struct uiArea uiArea;
typedef struct uiAreaHandler uiAreaHandler;
typedef struct uiAreaDrawParams uiAreaDrawParams;
typedef struct uiAreaMouseEvent uiAreaMouseEvent;
typedef struct uiAreaKeyEvent uiAreaKeyEvent;

typedef struct uiDrawContext uiDrawContext;

struct uiAreaHandler {
	void (*Draw)(uiAreaHandler *, uiArea *, uiAreaDrawParams *);
	// TODO document that resizes cause a full redraw for non-scrolling areas; implementation-defined for scrolling areas
	void (*MouseEvent)(uiAreaHandler *, uiArea *, uiAreaMouseEvent *);
	// TODO document that on first show if the mouse is already in the uiArea then one gets sent with left=0
	// TODO what about when the area is hidden and then shown again?
	void (*MouseCrossed)(uiAreaHandler *, uiArea *, int left);
	void (*DragBroken)(uiAreaHandler *, uiArea *);
	int (*KeyEvent)(uiAreaHandler *, uiArea *, uiAreaKeyEvent *);
};
void uiAreaSetSize(uiArea *a, int width, int height);
// TODO uiAreaQueueRedraw()
void uiAreaQueueRedrawAll(uiArea *a);
void uiAreaScrollTo(uiArea *a, double x, double y, double width, double height);
// TODO document these can only be called within Mouse() handlers
// TODO should these be allowed on scrolling areas?
// TODO decide which mouse events should be accepted; Down is the only one guaranteed to work right now
// TODO what happens to events after calling this up to and including the next mouse up?
// TODO release capture?
void uiAreaBeginUserWindowMove(uiArea *a);
void uiAreaBeginUserWindowResize(uiArea *a, unsigned int edge);
uiArea *uiNewArea(uiAreaHandler *ah);
uiArea *uiNewScrollingArea(uiAreaHandler *ah, int width, int height);